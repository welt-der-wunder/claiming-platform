<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;
use Hash;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{

      public function index()
      {
        return view('content.authentications.login');
      }  
    
      public function login(LoginRequest $request)
      {
            try {
                $credentials = $request->validated();

                if (Auth::attempt($credentials)) {
                    // dd('in');
                    return redirect('/')->withSuccess('Signed in');
                } else {
                    // dd('out');
                    return redirect("auth/login")->withErrors(['message' => 'Login details are not valid']);
                }

            } catch(Exception $e){
                Log::error($e->getMessage());
                return redirect("auth/login")->withErrors(['message' => 'Server Error']);
            }
      }
      
      public function logout() {
          Auth::logout();
          return $this->index();
      }

}
