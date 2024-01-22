@extends('layouts/contentNavbarLayout')

@section('title', 'Categories')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  {{__("Categories Tables")}}
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="px-3 card-header">{{__("Categories")}}</h5> 
        <a href="{{ route('categories.create') }}" class="mx-3 btn btn-primary">{{__("Add New")}}</a>
    </div>
 
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>{{__("Parent")}}</th>
          <th>Name</th>
          <th>{{__("Image")}}</th>
          <th>{{__("Date Created")}}</th>
          <th>{{__("Actions")}}</th>
        </tr>
      </thead>
  
      <tbody class="table-border-bottom-0">
        @foreach ($categories as $category)
        <tr>
          <td>{{$category->parent_id ? $category->parentCategory->name : ''}}</td>
          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$category->name}}</strong></td>
          
          <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
              <li data-bs-toggle="tooltip" data-bs-placement="top" class="avatar avatar-xs pull-up">
                @if($category->image)
                    <img src="{{asset('storage/'.$category->image->image_url)}}" alt="Avatar" class="rounded-circle">
                @else
                    <img src="{{asset('assets/img/placeholder.png')}}" alt="Avatar" class="rounded-circle">
                @endif
              </li>
            </ul>
          </td>
          <td><span class="badge bg-label-primary me-1">{{$category->created_at}}</span></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}"><i class="bx bx-edit-alt me-1"></i>{{__("Edit")}}</a>
                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item btn btn-default"><i class="bx bx-trash me-1"></i> {{__("Delete")}}</button>
                </form>
                
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
