@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');

@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
            @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
          </span>
          <span class="app-brand-text demo menu-text fw-bolder">{{config('variables.templateName')}}</span>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>
      @endif
      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav align-items-center ms-auto">

          <!-- Place this tag where you want the button to render. -->
          {{-- <li class="nav-item lh-1 me-3">
            <a class="github-button" href="https://github.com/themeselection/sneat-html-laravel-admin-template-free" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star themeselection/sneat-html-laravel-admin-template-free on GitHub">Star</a>
          </li> --}}
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
           
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
         
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow " href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online rounded-circle bg-white">
                <img src="{{ asset('assets/img/user.png') }}" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}">
                  <i class='bx bx-power-off me-2'></i>
                  <span class="align-middle">{{__("Log Out")}}</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>
  
      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
