@extends('layouts/contentNavbarLayout')

@section('title', 'Create User')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("User")}}/</span> {{__("Create")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("User Details")}}</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('systemusers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              @if ($errors->has('name'))
                  <div class="alert alert-danger">
                      {{ $errors->first('name') }}
                  </div>
                @endif
              </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Name</label>
            <input type="text" class="form-control" name="name" id="basic-default-fullname"/>
          </div>
          <div class="mb-3">
            @if ($errors->has('price'))
                <div class="alert alert-danger">
                    {{ $errors->first('price') }}
                </div>
              @endif
            </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">{{__("Role")}}</label>
            <select id="defaultSelect" class="form-select" name="role">
              <option disabled selected value="">- {{__("Choose Role")}} -</option>
              <option value="Admin">Admin</option>
              <option value="Agent">Agent</option>
              <option value="Moderator">Moderator</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">{{__("E-mail")}}</label>
            <input type="text" class="form-control" name="email" id="basic-default-email"/>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Password")}}</label>
            <input type="text" class="form-control" name="password" id="basic-default-password"/>
          </div>

          <div class="mb-4">
            <label class="form-label" for="basic-default-message">{{__("Branch")}}</label>
            <select id="defaultSelect" class="form-select" name="branch">
              <option disabled selected value="">- {{__("Choose Branch")}} -</option>
              @foreach ($branches as $branch)
              <option value="{{$branch->id}}">{{$branch->name}}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
