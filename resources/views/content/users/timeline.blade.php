@extends('layouts/contentNavbarLayout')

@section('title', 'User Details')
<style>
  .timeline {
    border-left: 1px solid hsl(0, 0%, 90%);
    position: relative;
    list-style: none;
  }

  .timeline .timeline-item {
    position: relative;
  }

  .timeline .timeline-item:after {
    position: absolute;
    display: block;
    top: 0;
  }

  .timeline .timeline-item:after {
    background-color: hsl(0, 0%, 90%);
    left: -38px;
    border-radius: 50%;
    height: 11px;
    width: 11px;
    content: "";
  }
</style>
@section('content')
<div class="d-flex align-content-center mx-0 my-3" style="gap: 10px;">
  <a href="{{ route('users') }}" class="btn btn-primary"><i class='bx bx-arrow-back'></i></a>
  <h4 class="fw-bold m-0 p-1"><span class="text-muted fw-light">{{__("User")}}/</span> {{__("Details")}}</h4>
</div>
<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-12">
    <div class="card mb-4 p-3">
      <div class="row">
        <div class="col-md-6">
          <div class="m-3">
            <h5 class="mb-0 fw-bold">{{__("Wallet Address")}}:</h5>
            <p class="my-3"><a style="color:#fff" href="https://bscscan.com/address/{{ $user->public_address }}"
                target="_blank">{{ $user->public_address ?? "/" }}</a></p>
          </div>
          <div class="m-3">
            <h5 class="mb-0 fw-bold">{{__("Reward Status")}}:</h5>
            <p class="my-3">{{ $user->reward_status }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="m-3">
            <h5 class="mb-0 fw-bold">{{__("Date Created")}}:</h5>
            <p class="my-3">{{ $user->created_at->format('d F Y h:i A') }}</p>
          </div>
          <div class="m-3">
            <h5 class="mb-0 fw-bold">{{__("Date Updated")}}:</h5>
            <p class="my-3">{{ $user->updated_at->format('d F Y h:i A') }}</p>
          </div>
        </div>
        <div class="col-md-12">

          <div class="m-3">
            <p class="my-3">Admin Actions:</p>
            <p class="my-3"><a style="color:#fff" href="https://bscscan.com/token/0x4518231a8fdf6ac553b9bbd51bbb86825b583263?a={{ $user->public_address }}"
                target="_blank">Old MLT Check</a></p>
            <p class="my-3"><a style="color:#fff" href="https://bscscan.com/token/0xf45611c32967cf1ce185f221725037b86d1cc337?a={{ $user->public_address }}"
                target="_blank">MLT Check</a></p>
          </div>
        </div>
      </div>

      @if($user->userLogs && $user->userLogs->count() > 0)
      <section class="p-4">
        <ul class="timeline">
          @foreach($user->userLogs as $userLog)
          <li class="timeline-item mb-5">
            <p>{!! $userLog->title ?? "" !!}</p>
            <p class="text-muted mb-2 fw-bold">{{ $userLog->created_at->format('d F Y h:i A') }}</p>
          </li>
          @endforeach
        </ul>
      </section>
      @endif
    </div>
  </div>
</div>
@endsection