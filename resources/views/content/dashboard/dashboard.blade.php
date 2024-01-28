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

    <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/wallet.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">{{__("User claimed")}}</span>
            <h3 class="card-title mb-2">{{ ($data && isset($data['user_claimed'])) ? $data['user_claimed'] : 0}}</h3>
           <!-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.14%</small>-->
          </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img src="{{asset('assets/img/icons/unicons/chart.png')}}" alt="chart success" class="rounded">
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">{{__("Unclaimed tokens")}}</span>
          <h3 class="card-title mb-2">{{ ($data && isset($data['unclaimed_tokens'])) ? $data['unclaimed_tokens'] : 0}}</h3>
          <!-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>-->
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="chart success" class="rounded">
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">{{__("Claimed tokens")}}</span>
          <h3 class="card-title mb-2">{{ ($data && isset($data['claimed_tokens'])) ? $data['claimed_tokens'] : 0}}</h3>
          <!-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>-->
        </div>
      </div>
    </div>
    
@endsection
