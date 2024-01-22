<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document\Document;
use App\Models\Document\DocumentNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Util\UserRoles;

class DashboardController extends Controller
{
    public function index()
  {

    $data = [
      "claimed_tokens" => User::where('role', UserRoles::$ROLE_USER)->count() ?? 0,
      "unclaimed_tokens" => User::where('role', UserRoles::$ROLE_USER)->count() ?? 0,
    ];

    return view('content.dashboard.dashboard', compact('data'));
  }

  public function getAllUsers()
  {
    $users = User::where('role', UserRoles::$ROLE_USER)->paginate(5);

    return view('content.users.index', compact('users'));
  }

  public function processRewards(Request $request)
  {
    $data = $request->all();

    if($data && isset($data['user_ids'])) {
      $users = User::where('role', UserRoles::$ROLE_USER)->where('', $data['user_ids'])->pluck('id')->toArray();

      if($users && count($users)) {
        User::whereIn('id', $users)->update(['is_reward'=> true]);
      }
    }

    session()->flash('success', 'Updated successfully!');

    return $this->getAllUsers();
  }
}
