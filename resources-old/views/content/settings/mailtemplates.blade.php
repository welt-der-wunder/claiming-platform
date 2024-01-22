@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')


<h4 class="fw-bold py-3 mb-4">
  {{__("Settings")}} /  {{__("Mail Templates")}}
</h4>

<!-- Basic Bootstrap Table -->


<!--/ Basic Bootstrap Table -->




<div class="card mt-5">

  <div class="d-flex align-items-center justify-content-between">
    <h5 class="px-3 card-header">{{__("Mail Templates")}}</h5> 
</div>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th>{{__("Name")}}</th>
        <th>{{__("Class")}}</th>
        <th>{{__("Type")}}</th>
        <th>{{__("Actions")}}</th>
      </tr>
    </thead>

    <tbody class="table-border-bottom-0">
      @foreach ($statuses as $status)
      <tr>
        <td>{{$status->name}}</td>
        <td>{{$status->class_name}}</td>
        <td>{{$status->is_order ? 'Order' : 'Offer'}}</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('templates-edit', $status->id) }}"><i class="bx bx-edit-alt me-1"></i>{{__("Edit")}}</a>
            </div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>

  <script>
    function updateHiddenFields() {
        var selectElement = document.getElementById('defaultSelect');
        var selectedValue = selectElement.value;
        var selectedCountry = selectedValue.split("-")[0];
        var selectedVat = selectedValue.split("-")[1];
        document.getElementById('country').value = selectedCountry;
        document.getElementById('vat').value = selectedVat;
    }
</script>
@endsection
