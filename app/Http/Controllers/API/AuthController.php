<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'username', 'password');

        if (isset($credentials['email'])) {
            $user = User::where('email', $credentials['email'])->first();
        }

        if (isset($credentials['username'])) {
            $user = User::where('username', $credentials['username'])->first();
        }

        if (! isset($user) || ! $user instanceof User) {
            return response()->json([
                'success' => false,
                'error' => 'invalid_credentials',
            ], 401);
        }

        if (! $user->password) {
            return response()->json([
                'success' => false,
                'error' => 'invalid_credentials',
            ], 401);
        }

        if (! $user->is_verified) {
            return response()->json([
                'success' => false,
                'error' => 'not_verified',
            ], 401);
        }

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'invalid_credentials',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to login, please try again.',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    { 
        // check if user exists | is_verified | and verification send in les then minutes
        $response = $this->resendVerificationEmail($request->email);
        if ($response instanceof JsonResponse) {
            return $response; // Return the JSON response to the frontend
        }

        try {

            $data    = $request->validated();
            $user    = User::create($data);
            $token   = Str::random(30);
            $pinCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('user_verifications')->insert([
                'user_id'    => $user->id,
                'token'      => $token,
                'pin_code'   => $pinCode,
                'created_at' =>  new \DateTime(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verification link has been sent to your email.',
            ]);

        } catch (Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function verifyUser(Request $request , string $verificationCode)
    {
        $email = $request->get('email');
        $check =  null;

        if($email) {
            $userByEmail = DB::table('users')->where('email', $email)->first();

            if($userByEmail) {
                $check = DB::table('user_verifications')
                            ->where('pin_code', $verificationCode)
                            ->where('user_id', $userByEmail->id)
                            ->first();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Account not found.'
                ]);
            }
        }
        else {
            $check = DB::table('user_verifications')->where('token', $verificationCode)->first();
        }
        
        if (! is_null($check)) {
    
            $user = User::findOrFail($check->user_id);

            if ($user->is_verified == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is already verified.',
                ]);
            }

            $user->email_verified_at = new \DateTime();
            $user->save();
            
            if($email){
                return response()->json([
                    'success' => true,
                    'message' => 'Email is verified.',
                    'token'   => $check->token
                ]);
            } else {
                $url = config('app.web_url'). '/registration?email-verification=success&token='. $verificationCode;
                return redirect()->away($url);
            }
      
        }

        if($email){
            return response()->json([
                'success' => false,
                'message' => 'Invalid Code.'
            ]);
        } else {
            $url = config('app.web_url'). '/registration?email-verification=invalid_code&token='. $verificationCode;
            return redirect()->away($url);
        }
 
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(): JsonResponse
    {
        $user = auth()->user();

        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * @param string|bool $token
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'user' => UserResource::make(auth()->user()),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl'),
        ]);
    }
}
