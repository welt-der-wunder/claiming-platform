@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center" style="overflow:visible">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
            </a>
            <ul class="navbar-nav flex-row align-items-center ms-auto">

              <!-- Place this tag where you want the button to render. -->
          
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow border p-2" href="javascript:void(0);" data-bs-toggle="dropdown">
                  {{ strtoupper(app()->getLocale()) }} <i class="bx bxs-chevron-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  @if (count(config('app.languages')))
                    @foreach (config('app.languages') as $langLocale => $lang)
                      <li>
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">
                          <span class="align-middle">{{ $lang }}</span>
                        </a>
                      </li>
                    @endforeach
                  @endif
                </ul>
              </li>
            </ul>
          </div>
          <!-- /Logo -->
  

          <form id="formAuthentication" class="mb-3" action="{{url('/auth/login-auth')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">{{__("Email or Username")}}</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
              @if ($errors->has('email'))
              <p class="text-danger">{{ $errors->first('email') }}</p>
              @endif
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">{{__("Password")}}</label>
                <a href="{{url('auth/forgot-password-basic')}}">
                  <small>{{__("Forgot Password")}}?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
               
              </div>
              @if ($errors->has('password'))
              <p class="text-danger">{{ $errors->first('password') }}</p>
              @endif
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  {{__("Remember Me")}}
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">{{__("Sign in")}}</button>
            </div>
          </form>

          {{-- <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register-basic')}}">
              <span>Create an account</span>
            </a>
          </p> --}}
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
