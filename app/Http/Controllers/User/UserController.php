<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\UserLog;
use App\Util\UserRoles;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers(Request $request)
    {
      $users = User::filter($request->all())->where('role', UserRoles::$ROLE_USER)->paginate($request->get('per_page', 20));
      $request->session()->put('search', $request->input('search'));
      $reward_statuses = User::REWARD_STATUSES;
      return view('content.users.index', compact(['users', 'reward_statuses']));
    }

    public function showTimeline(Request $request, $id)
    {

        $user = User::find($id)->load('userLogs');

        if(!$user) {
            return redirect()->back()->with('error','No user found');
        }

        return view('content.users.timeline', compact(['user']));
    }

    public function processMultipleRewards(Request $request)
    {
        $data = $request->all();
        if ($data && $request->get('user_ids')) {

          $reward_status =  User::REWARD_STATUS_REJECTED;
          if($request->get('confirm')) {
            $reward_status = User::REWARD_STATUS_SENT;
          }
          if($request->get('reject')) {
            $reward_status =  User::REWARD_STATUS_REJECTED;
          }
          if($request->get('pending')) {
            $reward_status = User::REWARD_STATUS_PENDING;
          }

          $users = User::whereIn('id', $request->get('user_ids'))
                       ->where('reward_status' ,'!=', $reward_status)
                       ->update(['reward_status' => $reward_status]);
  
          if($users) {
            $aryUsers = User::whereIn('id',$request->get('user_ids'))->get();
            UserLog::createLog($aryUsers, "<b>" . auth()->user()->email . "</b> has changed status to <b>". $reward_status . "</b>");
  
            session()->flash('success', 'Updated successfully!');
          } else {
            session()->flash('error', 'Wallet already in status ' . $reward_status .'!');
          }
        } else {
          session()->flash('error', 'No wallet address was selected!');
        }
        return redirect()->back();
    }
}
