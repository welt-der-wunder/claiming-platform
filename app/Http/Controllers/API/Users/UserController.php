<?php

namespace App\Http\Controllers\API\Users;

use App\Helper\FileUploader;
use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SetPasswordRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Core\File;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function me(): UserResource
    {
        $user = $this->user();
        Gate::authorize('me', $user);

        return UserResource::make($user);
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        Gate::authorize('update', $user);

        $data = $request->validated();

        if ($request->file('image')) {
            $image = FileUploader::storeToLocal($request->file('image'), 'users');
            $data['image_id'] = $image->id;
        }

        $user->update($data);

        return UserResource::make($user);
    }

    public function change_password(Request $request): JsonResponse
    {
        $user = $this->user();
        Gate::authorize('update', $user);

        $status = 200;
        $input = $request->all();
        $userid = auth()->user()->id;
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $status = 400;
            $arr = [
                'status' => $status,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($arr, $status);
        }

        try {
            if ((Hash::check(request('old_password'), $user->password)) == false) {
                $status = 400;
                $arr = [
                    'status' => $status,
                    'message' => 'Check your old password.',
                    'data' => [],
                ];

                return response()->json($arr, $status);
            }

            if ((Hash::check(request('new_password'), $user->password)) == true) {
                $status = 400;
                $arr = [
                    'status' => $status,
                    'message' => 'Please enter a password which is not similar then current password.',
                    'data' => [],
                ];

                return response()->json($arr, $status);
            }

            User::where('id', $userid)->update([
                'password' => Hash::make($input['new_password']),
            ]);
            $arr = [
                'status' => 200,
                'message' => 'Password updated successfully.',
                'data' => [],
            ];

            return response()->json($arr, $status);
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            $status = 400;
            $arr = [
                'status' => $status,
                'message' => $msg,
                'data' => [],
            ];

            return response()->json($arr, $status);
        }
    }

    public function set_password(SetPasswordRequest $request): UserResource
    {
        $user = $this->user();
        Gate::authorize('me', $user);

        $user->update([
            'password' => $request->password,
        ]);

        return UserResource::make($user);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', User::class);

        $users = SearchFormatter::getSearchQueries($request, User::class);

        $users = $users->paginate($request->input('per_page'));

        return UserResource::collection($users);
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $search = $request->input('q');

        $users = User::query();
        $users->whereNotNull('username');
        $users->where(function ($query) use ($search) {
            $query->where('username', 'LIKE', "%{$search}%");
        });

        $users = $users->with('image:id,image_url');

        $users = $users->paginate($request->input('per_page'));

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        Gate::authorize('view', $user);
        return UserResource::make($user);
    }

    public function store(CreateUserRequest $request): UserResource
    {
        Gate::authorize('create', User::class);

        $data = $request->validated();

        if ($request->file('image')) {
            $image = FileUploader::storeToLocal($request, 'image', 'users');
            $data['image_id'] = $image->id;
        }

        $user = User::create($data);
        $user->refresh();

        return UserResource::make($user);
    }

    public function destroy(User $user): JsonResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'User deleted!',
        ]);
    }

    public function sendResetPasswordEmail(int $userId): JsonResponse
    {
        $loggedInUser = $this->user();

        Gate::authorize('superAdmin', $loggedInUser);

        $status = 200;

        try {
            $user = User::findOrFail($userId);

            if ($user instanceof User && ! $user->is_active) {
                return response()->json([
                    'status' => 401,
                    'message' => 'You cannot send an email to the user to reset the password because the user has not yet completed the registration.',
                    'data' => [],
                ], 401);
            }

            $credentials = [
                'email' => $user->email,
            ];

            $response = Password::sendResetLink($credentials);

            if ($response === 'passwords.sent') {
                $response = 'An email to reset the password has been sent to the user.';

                return response()->json([
                    'status' => 200,
                    'message' => trans($response),
                    'data' => [],
                ], $status);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => trans($response),
                    'data' => [],
                ], 404);
            }
        } catch (\Swift_TransportException $ex) {
            $status = 400;
            $arr = [
                'status' => 400,
                'message' => $ex->getMessage(),
                'data' => [],
            ];
        } catch (Exception $ex) {
            $status = 400;
            $arr = [
                'status' => 400,
                'message' => $ex->getMessage(),
                'data' => [],
            ];
        }

        return response()->json($arr, $status);
    }

    public function removeProfileImage()
    {
        $user = User::find(auth()->id());
        Gate::authorize('update', $user);

        if($user && $user->image_id) {  
            $image = File::find($user->image_id);

            if($image) {
                $image->delete();
            }

            $user->image_id = null;
            $user->save();
        }

        return UserResource::make($user);
    }
}
