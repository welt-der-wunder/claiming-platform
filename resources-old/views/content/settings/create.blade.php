@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Settings")}}
</h4>

<!-- Basic Bootstrap Table -->

<h5 class="mb-3 mt-5">{{__("Add VAT")}}</h5>
<form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div class="row mb-2">
  <div class="col-sm-4">
    <label class="form-label" for="basic-default-fullname">{{__("Country")}}</label>
    <input class="form-control" type="text" name="country" id="country" placeholder="Germany" value="{{ old('country')}}" required />

    <label class="form-label" for="basic-default-fullname">{{__("Vat")}}</label>
    <input class="form-control" type="text" name="vat" id="vat" placeholder="0" value="{{ old('vat')}}" required />

    <div class="mt-3">
      <button type="submit" name="" value="" style="border-color:#2455a4; background-color:#2455a4" class="btn btn-primary mb-1">{{__("Add")}}</button>
    </div>
  </div>
</div>
</form>
<!--/ Basic Bootstrap Table -->



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
