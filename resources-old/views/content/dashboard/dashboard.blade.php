@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')


<div class="row">
  <div class="col-6 mb-4">
    <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-center ">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">{{__("Total Active Cars")}}</h5>
              <span class="badge bg-label-warning rounded-pill"></span>
            </div>
            <div class="mt-sm-auto">
              
              <h3 class="mb-0">{{$totalActiveCars}}</h3>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between  flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-center ">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">{{__("Total Cars")}}</h5>
              <span class="badge bg-label-warning rounded-pill"></span>
            </div>
            <div class="mt-sm-auto">
              
              <h3 class="mb-0">{{$totalCars}}</h3>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>


  <div class="col-6 mb-4">
    <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-center ">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">{{__("Cars for refuel")}}</h5>
              <span class="badge bg-label-warning rounded-pill"></span>
            </div>
            <div class="mt-sm-auto">
              
              <h3 class="mb-0">{{$totalCarsRefuel}}</h3>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between  flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-center ">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">{{__("Dirty Cars")}}</h5>
              <span class="badge bg-label-warning rounded-pill"></span>
            </div>
            <div class="mt-sm-auto">
              
              <h3 class="mb-0">{{$totalDirtyCars}}</h3>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>

</div>


@endsection
