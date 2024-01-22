@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Users Tables")}}
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="px-3 card-header">{{__("Users")}}</h5> 
        <a href="{{ route('systemusers.create') }}" class="mx-3 btn btn-primary">{{__("Add New")}}</a>
    </div>
 
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>{{__("Role")}}</th>
          <th>{{__("E-mail")}}</th>
          <th>{{__("Branch")}}</th>
          <th>{{__("Date Created")}}</th>
          <!--<th>Actions</th>-->
        </tr>
      </thead>
  
      <tbody class="table-border-bottom-0">
        @foreach ($users as $user)
        <tr>
          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{$user->name}}</td>
          <td>{{$user->role}}</td>
          <td>{{$user->email}}</td>
          <td>@if(isset($user->branch))
            {{$user->branch->name}}
            @endif</td>
          <td><span class="badge bg-label-primary me-1">{{$user->created_at}}</span></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('systemusers.edit', $user->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <form action="{{ route('systemusers.destroy',$user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item btn btn-default"><i class="bx bx-trash me-1"></i> Delete</button>
                </form>
                
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
      
    </table>
    <div class="container">
      <div class="d-flex p-2 justify-content-center">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
