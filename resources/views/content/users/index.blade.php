@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Users Tables")}}
</h4>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="table-responsive text-nowrap">
    <form action="{{ route('processRewards') }}" method="post">
      @csrf
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{__("Wallet Address")}}</th>
          <th>{{__("Date Created")}}</th>
          <th class="text-center">{{__("Reward Sent")}}</th>
          <!--<th>Actions</th>-->
        </tr>
      </thead>
  
      <tbody class="table-border-bottom-0">
        @php
            $i = 1;
        @endphp
        @foreach ($users as $user)
        <tr>
          <td>{{$i}}</td>
          <td>{{$user->public_address}}</td>
          <td>{{$user->created_at}}</td>
          <td align="center">
            <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{$user->id}}">
          </td>
        </tr>
        @php
          $i++
        @endphp
        @endforeach
      </tbody>
    </table>
    @if ($users && count($users))
      <div class="container">
        <div class="d-flex p-2 justify-content-end">
          <button type="submit" class="btn btn-primary">{{__('Process Rewards')}}</button>
        </div>
      </div>
    @endif
    </form>
    <div class="container">
      <div class="d-flex p-2 justify-content-center">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
