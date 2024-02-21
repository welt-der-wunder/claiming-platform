@extends('layouts/contentNavbarLayout')

@section('title', 'Claimed Users')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Claimed Users")}}
</h4>

@if(session('success'))
<div class="alert text-white alert-dismissible fade show bg-success" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close rounded-circle bg-white p-2 mx-2"
    style="top: 50%; transform: translateY(-50%);" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert text-white alert-dismissible fade show bg-danger" role="alert">
  {{ session('error') }}
  <button type="button" class="btn-close rounded-circle bg-white p-2 mx-2"
    style="top: 50%; transform: translateY(-50%);" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Basic Bootstrap Table -->
<div class="card">
  <form action="{{ route('exportData') }}" method="post">
    @csrf
    <div class="mx-3 text-end my-3">
      <input type="hidden" name="url_params" value="<?php if(isset($_SERVER['QUERY_STRING'])) echo $_SERVER['QUERY_STRING']; ?>" />
      <button type="submit" name="export" value="1" class="btn btn-primary m-1 fade show" id="exportBtn"
        onclick="return exportData();">{{__('Export')}}</button>
    </div>
  </form>
  <form action="{{ route('users') }}" method="GET">
    @csrf
    <div class="row m-2 my-3 justify-content-between">
      <div class="col-md-6 my-1">
        <div class="d-flex">
          <input type="text" style="margin-right:10px" class="form-control" name="search"
            placeholder="{{__('Search by wallet')}}" value="{{ old('search', session('search')) }}">
          <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
        </div>
      </div>
      <div class="row col-md-6 my-1">
        <div class="col-6">
          <select id="" class="form-select" name="reward_status" onchange="submit()">
            <option value=""> {{__("All statuses")}} </option>
            @foreach ($reward_statuses as $status)
            <option value="{{ $status }}" @if (isset($_GET['reward_status']) && $_GET['reward_status']==$status)
              {{"selected"}} @endif>{{__( $status )}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
          <label style="min-width: 100px;" class="" for="">Per Page:</label>
          <select style="max-width: 100px;" id="" class="form-select" name="per_page" onchange="submit()">
            <option value="20" @if (isset($_GET['per_page']) && $_GET['per_page']==20) {{"selected"}} @endif>20</option>
            <option value="50" @if (isset($_GET['per_page']) && $_GET['per_page']==50) {{"selected"}} @endif>50</option>
            <option value="100" @if (isset($_GET['per_page']) && $_GET['per_page']==100) {{"selected"}} @endif>100
            </option>
          </select>
        </div>
      </div>
    </div>
  </form>
  <div class="table-responsive text-nowrap">
    <form action="{{ route('processMultipleRewards') }}" method="post">
      @csrf
      <div class="mx-3 text-end">
        <button type="submit" name="confirm" value="1" class="btn btn-primary m-1 fade show d-none" id="confirmBtn"
          onclick="return confirmAction();">{{__('Confirm')}}</button>
        <button type="submit" name="reject" value="1" class="btn btn-primary m-2 fade show d-none" id="rejectBtn"
          onclick="return confirmAction();">{{__('Reject')}}</button>
        <button type="submit" name="pending" value="1" class="btn btn-primary m-2 fade show d-none" id="pendingBtn"
          onclick="return confirmAction();">{{__('Move Back')}}</button>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th class="text-center">
              {{-- {{__('Confirm / Reject')}} --}}
              <input type="checkbox" class="form-check-input w-10 h-10" onchange="updateCheckboxes()" id="selectAll" />
            </th>
            <th>#</th>
            <th>{{__("Wallet Address")}}</th>
            <th>{{__("Date Created")}}</th>
            <th class="text-center">{{__("Reward Status")}}</th>
            <th class="text-center">{{_("Actions")}}</th>
          </tr>
        </thead>
        @if ($users && count($users) > 0)
        <tbody class="table-border-bottom-0">
          @foreach ($users as $index => $user)
          <tr>
            <td align="center">
              <input onchange="updateButtons()" class="form-check-input w-10 h-10" name="user_ids[]" type="checkbox"
                value="{{$user->id}}">
            </td>
            <td>{{$user->id}}</td>
            <td><a style="color:#fff" href="https://bscscan.com/address/{{ $user->public_address }}"
                target="_blank">{{$user->public_address}}</a>
              |
              <a style="font-size: 11px; color:#fff"
                href="https://bscscan.com/token/0x4518231a8fdf6ac553b9bbd51bbb86825b583263?a={{ $user->public_address }}"
                target="_blank">OLD</a> |
              <a style="font-size: 11px; color:#fff"
                href="https://bscscan.com/token/0xf45611c32967cf1ce185f221725037b86d1cc337?a={{ $user->public_address }}"
                target="_blank">ACTIVE</a>
  </div>
  </td>
  <td>{{$user->created_at}}</td>
  <td align="center">
    {{ $user->reward_status }}
  </td>
  <td align="center"><a class="action-link-c" href="{{ route('showTimeline', $user->id) }}"><i
        class='bx bxs-show text-wite'></i></a></td>
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
  </form>
  <div class="container">
    <div class="d-flex p-2 justify-content-center">
      {{ $users->links() }}
    </div>
  </div>
</div>
</div>
<script>
  function updateButtons() {
      var checkboxes = document.getElementsByName('user_ids[]');
      var confirmBtn = document.getElementById('confirmBtn');
      var rejectBtn = document.getElementById('rejectBtn');
      var pendingBtn = document.getElementById('pendingBtn');
      var atLeastOneChecked = false;
  
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].checked) {
              atLeastOneChecked = true;
              break;
          }
      }
  
      if (atLeastOneChecked) {
          confirmBtn.classList.remove('d-none');  // Remove the d-none class
          rejectBtn.classList.remove('d-none');   // Remove the d-none class
          pendingBtn.classList.remove('d-none');   // Remove the d-none class
      } else {
          confirmBtn.classList.add('d-none');  // Add the d-none class
          rejectBtn.classList.add('d-none');   // Add the d-none class
          pendingBtn.classList.add('d-none');   // Add the d-none class
      }
  }
  function updateCheckboxes() {
    var headerCheckbox = document.getElementById('selectAll');
    var checkboxes = document.getElementsByName('user_ids[]');
  
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = headerCheckbox.checked;
    }
    // Call updateButtons to handle the state of the buttons
    updateButtons();
  }
  function confirmAction() {
      var checkboxes = document.getElementsByName('user_ids[]');
      var atLeastOneChecked = false;
  
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].checked) {
              atLeastOneChecked = true;
              break;
          }
      }
  
      if (!atLeastOneChecked) {
          alert("Please select at least one user before proceeding.");
          return false;
      }
  
      var confirmation = window.confirm("Are you sure you want to proceed?");
      if (confirmation) {
          // Proceed with form submission
          document.forms[2].submit();  // Assuming the form is the second form on the page, adjust if necessary
      } else {
          // User canceled the action
          return false;
      }
  }
  function exportData() {
      const queryString = window.location.search;
console.log(queryString);

      var atLeastOneChecked = false
  
      var confirmation = window.confirm("Are you sure you want to export?");
      if (confirmation) {
          // Proceed with form submission
          document.forms[0].submit();  // Assuming the form is the second form on the page, adjust if necessary
      } else {
          // User canceled the action
          return false;
      }
  }
</script>
@endsection