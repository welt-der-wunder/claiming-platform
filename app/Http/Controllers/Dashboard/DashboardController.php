<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document\Document;
use App\Models\Document\DocumentNote;
use App\Models\TokenHolder;
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
      "user_claimed" => User::where('role', UserRoles::$ROLE_USER)->count() ?? 0,
      "unclaimed_tokens" => TokenHolder::where('is_claimed', false)->count() ?? 0,
      "claimed_tokens" => TokenHolder::where('is_claimed', true)->count() ?? 0,
    ];

    return view('content.dashboard.dashboard', compact('data'));
  }

  public function getAllUsers(Request $request)
  {
    $users = User::filter($request->all())->where('role', UserRoles::$ROLE_USER)->paginate(1);
    $request->session()->put('search', $request->input('search'));

    return view('content.users.index', compact('users'));
  }

  public function getAllTokenHolders(Request $request) 
  {
    $tokenHolders = TokenHolder::filter($request->all())->paginate(15);
    $request->session()->put('holder_search', $request->input('holder_search'));

    return view('content.token-holders.index', compact('tokenHolders'));
  }
  
  public function processRewards(Request $request)
  {
      $data = $request->all();

      if ($data && $request->get('user_id')) {
            $user = User::find($request->get('user_id'));
            if ($user) {          
                $user->update(['is_reward' => 1]);
                session()->flash('success', 'Updated successfully!');
            } else {
                session()->flash('error', 'User not found!');
            }
      } else {
        session()->flash('error', 'User not found!');
      }

      return redirect()->back();
  }

  public function createTokenHolder(Request $request) {

    if ($request->get('holder_address')) { 

      TokenHolder::create(['holder_address'=> trim($request->get('holder_address'))]);

      session()->flash('success', 'Created successfully!');
  
    } else {
      session()->flash('error', 'Wallet address not entered!');
    }

    return redirect()->back();
  }
}
