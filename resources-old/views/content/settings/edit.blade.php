@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Settings')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("Settings")}}/</span> {{__("Edit")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("VAT Details")}}</h5>
      </div>
        <div class="card-body">
          <label class="form-label" for="basic-default-fullname">{{$countryVat->country}}</label>
          <form action="{{ route('settings.update', ['setting' => $countryVat->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="mb-3">
                @if ($errors->has('vat'))
                    <div class="alert alert-danger">
                        {{ $errors->first('vat') }}
                    </div>
                  @endif
                </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("Vat")}}</label>
                <input type="text" class="form-control" name="vat"  id="basic-default-fullname" value="{{$countryVat->vat}}"/>
                <input type="hidden" class="form-control" name="country"  id="basic-default-fullname" value="{{$countryVat->country}}"/>
                
              </div>
              <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

@endsection
