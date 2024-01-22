@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("User")}}/</span> {{__("Edit")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("User Details")}}</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('systemusers.update', ['systemuser' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              @if ($errors->has('name'))
                  <div class="alert alert-danger">
                      {{ $errors->first('name') }}
                  </div>
                @endif
              </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Name</label>
            <input type="text" class="form-control" name="name"  id="basic-default-fullname" value="{{$user->name}}"/>
          </div>
          <div class="mb-3">
            @if ($errors->has('role'))
                <div class="alert alert-danger">
                    {{ $errors->first('role') }}
                </div>
              @endif
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-company">{{__("Role")}}</label>
              <select id="defaultSelect" class="form-select" name="role">
                <option selected value="{{ $user->role }}">{{ $user->role }}</option>
                @foreach (['Admin', 'Agent', 'Moderator'] as $option)
                    @if ($option !== $user->role)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endif
                @endforeach
            </select>
            </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-company">{{__("E-mail")}}</label>
            <input type="text" class="form-control" name="email" id="basic-default-company" value="{{$user->email}}"/>
          </div>
          <div class="mb-4">
            <label class="form-label" for="basic-default-message">{{__("Branch")}}</label>
            <select id="defaultSelect" class="form-select" name="branch_id">
              <option selected value="{{$user->branch->id}}">{{$user->branch->name}}</option>
              @foreach ($branches as $branch)
              @if ($branch->id !== $user->branch->id)
              <option value="{{$branch->id}}">{{$branch->name}}</option>
              @else
              
              @endif
             
              @endforeach
            </select>
          </div>
          
      

          <div class="card mb-4">
            <div class="card-body">
              <div class="row gy-3">
                <div class="col-md">
                  <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="show_total" value="1" id="defaultCheck1" @if($user->show_total) {{'checked'}} @endif />
                    <label class="form-check-label" for="defaultCheck1">
                      {{__("Show Totals")}}
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="print_pdf" value="1" id="defaultCheck2" @if($user->print_pdf) {{'checked'}} @endif/>
                    <label class="form-check-label" for="defaultCheck2">
                      {{__("Print PDF")}}
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="print_offer" value="1" id="defaultCheck3" @if($user->print_offer) {{'checked'}} @endif/>
                    <label class="form-check-label" for="defaultCheck3">
                      {{__("Print Offer")}}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
          <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  // Get the file input element and the product image element
  const fileInput = document.getElementById('formFile');
  const productImage = document.getElementById('product-image');
  
  // Add an event listener to the file input
  fileInput.addEventListener('change', function() {
    // Get the selected file and create a URL for it
    const file = fileInput.files[0];
    const url = URL.createObjectURL(file);
    
    // Update the product image element with the new URL
    productImage.src = url;
  });


</script>
@endsection
