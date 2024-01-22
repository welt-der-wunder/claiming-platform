@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')


<h4 class="fw-bold py-3 mb-4">
  {{__("Settings")}} /  {{__("Vat")}}
</h4>

<!-- Basic Bootstrap Table -->


<!--/ Basic Bootstrap Table -->




<div class="card mt-5">

  <div class="d-flex align-items-center justify-content-between">
    <h5 class="px-3 card-header">{{__("VAT By Country")}}</h5> 
    <a href="{{ route('settings.create') }}" class="mx-3 btn btn-primary">{{__("Add New")}}</a>
</div>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th>{{__("Country")}}</th>
        <th>{{__("Vat")}}</th>
        <th>{{__("Actions")}}</th>
      </tr>
    </thead>

    <tbody class="table-border-bottom-0">
      @foreach ($countries_vats as $countries_vat)
      <tr>
        <td>{{$countries_vat->country}}</td>
        <td>{{$countries_vat->vat}}%</td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('settings.edit', $countries_vat->id) }}"><i class="bx bx-edit-alt me-1"></i>{{__("Edit")}}</a>
              <form action="{{ route('settings.destroy',$countries_vat->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item btn btn-default"><i class="bx bx-trash me-1"></i>{{__("Delete")}}</button>
              </form>
              
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
