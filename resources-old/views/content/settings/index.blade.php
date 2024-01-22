@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Settings")}}
</h4>

<!-- Basic Bootstrap Table -->
<head>
  <style>

  .select-btn:hover{
      background-color: rgb(103, 46, 235)!important;
      color: white!important;
    }

  </style>
</head>

<!--/ Basic Bootstrap Table -->
<hr class="mt-2 mb-3"/>
<div class="d-flex align-items-center justify-content-start mb-3">
  
  +<a href="{{ route('vat') }}" style="background-color:rgb(197, 197, 197); width:200px;" class="mx-3 btn select-btn">{{__("Vat")}}</a>
</div>
<div class="d-flex align-items-center justify-content-start mb-3" >
 
  +<a href="{{ route('branch') }}" style="background-color:rgb(197, 197, 197); width:200px" class="mx-3 btn select-btn">{{__("Branch")}}</a>
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
