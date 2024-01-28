@extends('layouts/contentNavbarLayout')

@section('title', 'Token Holders')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Token Holders")}}
</h4>

@if(session('success'))
  <div class="alert text-white alert-dismissible fade show bg-success" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close rounded-circle bg-white p-2 mx-2" style="top: 50%; transform: translateY(-50%);" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert text-white alert-dismissible fade show bg-danger" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close rounded-circle bg-white p-2 mx-2" style="top: 50%; transform: translateY(-50%);" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Basic Bootstrap Table -->
<div class="card">
  <form class="mb-1" action="{{ route('token-holders') }}" method="GET">
    <div class="row mx-2 mt-3 justify-content-between">
      <div class="col-sm-6 mb-2">
          <div class="d-flex">
            <input type="text" style="margin-right:10px" class="form-control" name="holder_search" placeholder="{{__('Search by wallet')}}" value="{{ old('holder_search', session('holder_search')) }}">
            <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
          </div>
      </div>
      <div class="col-sm-3 col-lg-3 mb-2">
        <select id="" class="form-select" name="is_claimed" onchange="submit()">
              <option value=""> {{__("All statuses")}} </option>
              <option value="1" @if (isset($_GET['is_claimed']) && $_GET['is_claimed'] == 1) {{"selected"}} @endif>{{__('Claimed')}}</option>
              <option value="0" @if (isset($_GET['is_claimed']) && $_GET['is_claimed'] == 0) {{"selected"}} @endif>{{__('Unclaimed')}}</option>
        </select>
      </div>
    </div>
  </form>
  <div class="row m-2 justify-content-end">
    <div class="col-sm-3 col-lg-3 mb-2 text-end">
    <!-- Button to Open Modal -->
      <button type="button" class="btn btn-primary m-auto" data-bs-toggle="modal" data-bs-target="#createRecordModal">
        {{__('Add')}}
      </button>
    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{__("Wallet Address")}}</th>
          <th>{{__("Date Created")}}</th>
          <th class="text-center">{{__("Claim Status")}}</th>
        </tr>
      </thead>
      @if ($tokenHolders && count($tokenHolders) > 0)  
      <tbody class="table-border-bottom-0">
        @foreach ($tokenHolders as $tokenHolder)
        <tr>
          <td>{{$tokenHolder->id}}</td>
          <td>{{ $tokenHolder->holder_address ?? $tokenHolder->from}}</td>
          <td>{{$tokenHolder->created_at ?? '/'}}</td>
          <td align="center">   
             {{ $tokenHolder->is_claimed ? 'Claimed' : 'Unclaimed'}}
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
    <div class="container mt-2">
      <div class="d-flex p-2 justify-content-center">
        {{ $tokenHolders->links() }}
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection

<!-- Create Record Modal -->
<div class="modal fade" id="createRecordModal" tabindex="-1" aria-labelledby="createRecordModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded" style="top: 50%; transform: translateY(-50%);">
    <div class="modal-content" style="background: #1d162a;">
      <div class="modal-header">
        <h5 class="modal-title" id="createRecordModalLabel">{{__('Add token holder')}}</h5>
        <button type="button" class="btn-close rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add your form fields for creating a new record here -->
        <form action="{{ route('create-token-holder') }}" method="POST">
          @csrf
          <!-- Add your form fields here -->
          <input required type="text" class="form-control mb-3" name="holder_address" placeholder="{{__('Wallet address')}}">
          <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
        </form>
      </div>
    </div>
  </div>
</div>