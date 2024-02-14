@extends('layouts/contentNavbarLayout')

@section('title', 'Token Holders')
<style>

.file-input-b::file-selector-button {
  font-weight: bold;
  /* color: #1d162a !important; */
  background: transparent !important;
  padding: 0.5em;
  border: thin solid grey;
  border-radius: 3px;
}

</style>
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
    @csrf
    <div class="row m-2 my-3 justify-content-between">
      <div class="col-lg-6 my-1">
          <div class="d-flex">
            <input type="text" style="margin-right:10px" class="form-control" name="holder_search" placeholder="{{__('Search by wallet')}}" value="{{ old('search', session('holder_search')) }}">
            <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
          </div>
      </div>
      <div class="row col-lg-6 my-1">
        <div class="col-6">
          <select id="" class="form-select" name="status" onchange="submit()">
            <option value=""> {{__("All statuses")}} </option>
            @foreach ($statuses as $status)
            <option value="{{ $status }}" @if (isset($_GET['status']) && $_GET['status'] == $status) {{"selected"}} @endif>{{__( $status )}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
          <label style="min-width: 100px;" class="" for="">Per Page:</label>
          <select style="max-width: 100px;" id="" class="form-select" name="per_page" onchange="submit()">
                <option value="20" @if (isset($_GET['per_page']) && $_GET['per_page'] == 20) {{"selected"}} @endif>20</option>
                <option value="50" @if (isset($_GET['per_page']) && $_GET['per_page'] == 50) {{"selected"}} @endif>50</option>
                <option value="100" @if (isset($_GET['per_page']) && $_GET['per_page'] == 100) {{"selected"}} @endif>100</option>
          </select>
        </div>
      </div>
    </div>
  </form>
  <div class="table-responsive text-nowrap">
    <form action="{{ route('holderStatusChange') }}" method="post">
      @csrf
      <div class="mx-3 m-1 d-flex justify-content-between">
        <div class="mx-1">
          <button type="submit" name="block" value="1" class="btn btn-primary m-2 fade show d-none" id="rejectBtn" onclick="return confirmAction();">{{__('Block')}}</button>
        </div>
        <div class="mx-1 d-flex" style="gap: 20px;">
          <button type="button" class="btn btn-primary m-auto" data-bs-toggle="modal" data-bs-target="#createRecordModal">
            {{__('Add')}}
          </button>
          <button type="button" class="btn btn-primary m-auto" data-bs-toggle="modal" data-bs-target="#fileImportModal">
            {{__('Import Holders')}}
          </button>
        </div>
      </div>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">
            <input type="checkbox" class="form-check-input w-10 h-10" onchange="updateCheckboxes()" id="selectAll"/>
          </th>
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
          <td align="center">
            <input onchange="updateButtons()" class="form-check-input w-10 h-10" name="holder_ids[]" type="checkbox" value="{{$tokenHolder->id}}">
          </td>
          <td>{{$tokenHolder->id}}</td>
          <td><a style="color:#fff" href="https://bscscan.com/address/{{ $tokenHolder->holder_address ?? $tokenHolder->from}}" target="_blank">{{ $tokenHolder->holder_address ?? $tokenHolder->from}}</a></td>
          <td>{{$tokenHolder->created_at ?? '/'}}</td>
          <td align="center">   
             {{ $tokenHolder->status }}
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
    </form>
    <div class="container mt-2">
      <div class="d-flex p-2 justify-content-center">
        {{ $tokenHolders->links() }}
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

<script>
  function updateButtons() {
      var checkboxes = document.getElementsByName('holder_ids[]');
      var rejectBtn = document.getElementById('rejectBtn');
      var atLeastOneChecked = false;
  
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].checked) {
              atLeastOneChecked = true;
              break;
          }
      }
  
      if (atLeastOneChecked) {
          rejectBtn.classList.remove('d-none');   // Remove the d-none class
      } else {
          rejectBtn.classList.add('d-none');   // Add the d-none class
      }
  }
  function updateCheckboxes() {
    var headerCheckbox = document.getElementById('selectAll');
    var checkboxes = document.getElementsByName('holder_ids[]');
  
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = headerCheckbox.checked;
    }
    // Call updateButtons to handle the state of the buttons
    updateButtons();
  }
  function confirmAction() {
      var checkboxes = document.getElementsByName('holder_ids[]');
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
          document.forms[1].submit();  // Assuming the form is the second form on the page, adjust if necessary
      } else {
          // User canceled the action
          return false;
      }
  }
  
  function submitImportForm(event) {
        event.preventDefault();
        document.querySelector('#importForm');
        console.log('--------', importForm);
        if (importForm) {
            importForm.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var fileInput = document.querySelector('.input-file');
        if (fileInput) {
            fileInput.addEventListener('change', submitImportForm);
        }
    });

  </script>

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
<div class="modal fade" id="fileImportModal" tabindex="-1" aria-labelledby="fileImportModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded" style="top: 50%; transform: translateY(-50%);">
    <div class="modal-content" style="background: #1d162a;">
      <div class="modal-header">
        <h5 class="modal-title" id="fileImportModalLabel">{{__('Import token holder')}}</h5>
        <button type="button" class="btn-close rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add your form fields for creating a new record here -->
        <form action="{{ route('importHolders') }}" method="POST" id="importForm" enctype="multipart/form-data">
          @csrf
            <input required type="file" class="file-input-b form-control mb-3" name="excel_file"/>
            <button type="submit" class="btn btn-primary">{{__('Import')}}</button>
        </form>
      </div>
    </div>
  </div>
</div>