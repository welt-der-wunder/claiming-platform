@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Settings")}} /  {{__("Branch")}}
</h4>

<!-- Basic Bootstrap Table -->


<!--/ Basic Bootstrap Table -->


  <div class="card mt-5">

    <div class="d-flex align-items-center justify-content-between">
      <h5 class="px-3 card-header">{{__("Branches")}}</h5> 
      <a href="{{ route('branch.create') }}" class="mx-3 btn btn-primary">{{__("Add New")}}</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>{{__("Name")}}</th>
          <th>{{__("Country")}}</th>
          <th>{{__("City")}}</th>
          <th>{{__("Postal Code")}}</th>
          <th>{{__("Address 1")}}</th>
          <th>{{__("Actions")}}</th>
        </tr>
      </thead>
  
      <tbody class="table-border-bottom-0">
        @foreach ($branches as $branch)
        <tr>
          <td>{{$branch->name}}</td>
          <td>{{$branch->country}}</td>
          <td>{{$branch->city}}</td>
          <td>{{$branch->post_code}}</td>
          <td>{{$branch->address_line_1}}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('branch.edit', $branch->id) }}"><i class="bx bx-edit-alt me-1"></i>{{__("Edit")}}</a>
                <form action="{{ route('branch.destroy',$branch->id) }}" method="POST">
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
