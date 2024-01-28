@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Users")}}
</h4>

@if(session('success'))
  <div class="alert text-white alert-dismissible fade show bg-success" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show bg-white" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Basic Bootstrap Table -->
<div class="card">
  <form action="{{ route('users') }}" method="GET">
    <div class="row m-2 my-4 justify-content-between">
      <div class="col-sm-6">
          <div class="d-flex">
            <input type="text" style="margin-right:10px" class="form-control" name="search" placeholder="{{__('Search by wallet')}}" value="{{ old('search', session('search')) }}">
            <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
          </div>
      </div>
      <div class="col-sm-3 col-lg-3">
        <select id="" class="form-select" name="is_reward" onchange="submit()">
              <option value=""> {{__("All statuses")}} </option>
              <option value="0" @if (isset($_GET['is_reward']) && $_GET['is_reward'] == 0) {{"selected"}} @endif>{{__('Pending')}}</option>
              <option value="1" @if (isset($_GET['is_reward']) && $_GET['is_reward'] == 1) {{"selected"}} @endif>{{__('Sent')}}</option>
        </select>
      </div>
    </div>
  </form>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{__("Wallet Address")}}</th>
          <th>{{__("Date Created")}}</th>
          <th class="text-center">{{__("Reward")}}</th>
          <th class="text-center">{{__("Actions")}}</th>
        </tr>
      </thead>
      @if ($users && count($users) > 0)  
      <tbody class="table-border-bottom-0">
        @foreach ($users as $index => $user)
        <tr>
          <td>{{$user->id}}</td>
          <td>{{$user->public_address}}</td>
          <td>{{$user->created_at}}</td>
          <td align="center">   
             {{ $user->is_reward ? 'Sent' : 'Pending'}}
          </td>
          <td align="center">
            <form action="{{ route('processRewards') }}" method="post">
              @csrf
              <input type="hidden" name="user_id" value="{{$user->id}}">
              <button {{ $user->is_reward ? 'disabled' : '' }} type="submit" class="btn btn-primary">{{__('Send')}}</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
      @else
        <tfoot class="my-3 border-0">
          <tr class=" border-0 my-3">
            <th class="text-center border-0" align="center" colspan="5">
              <p class="my-3">{{ _('No data') }}</p>
            </th>
          </tr>
        </tfoot>
      @endif
    </table>
    <div class="container">
      <div class="d-flex p-2 justify-content-center">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
