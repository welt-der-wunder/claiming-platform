@extends('layouts/contentNavbarLayout')

@section('title', 'Create Category')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("Category")}}/</span> {{__("Create")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("Category Details")}}</h5>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bs-tab" data-bs-toggle="tab" data-bs-target="#bs" type="button" role="tab" aria-controls="bs" aria-selected="true">BS</button>
          </li>
          @foreach (getAvailableLanguages() as $lang)
          @if (!$lang['exclude'])
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="{{$lang['code']}}-tab" data-bs-toggle="tab" data-bs-target="#{{$lang['code']}}" type="button" role="tab" aria-controls="{{$lang['code']}}" aria-selected="false">{{strtoupper($lang['code'])}}</button>
          </li>
          @endif
          @endforeach
        </ul>
      </div>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card-body tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="bs" role="tabpanel" aria-labelledby="bs-tab">
        
              <div class="mb-3">
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                  @endif
                </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">{{__("Name")}}</label>
              <input type="text" class="form-control" name="name" id="basic-default-fullname"/>
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-parent_id">{{__("Parent Category")}}</label>

              <select id="parent_id" class="form-select" name="parent_id">
                <option value="">{{__("Select Category")}}</option>
                @foreach ($categories as $category)
                <option value={{$category->id}} {{(old('parent_id')==$category->id)?
                  'selected':''}}>{{$category->parent_id ? "---".$category->name : $category->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">{{__("Image")}}</label>
              <input class="form-control" type="file" name="image" id="formFile">
            </div>
            <div class="mb-3">
              <label class="form-label">{{__("Active")}}</label>
              <br>
              <input type="checkbox" class="form-check-input" name="is_active" checked value="1"/>
            </div>
            <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
        </div>
        @foreach (getAvailableLanguages() as $lang)
        @if (!$lang['exclude'])
          
        <div class="tab-pane fade" id="{{$lang['code']}}" role="tabpanel" aria-labelledby="{{$lang['code']}}-tab">
          <div class="mb-3">
            @if ($errors->has('name'))
                <div class="alert alert-danger">
                    {{ $errors->first('name') }}
                </div>
              @endif
            </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Name")}}</label>
            <input type="text" class="form-control" name="translation[{{$lang['code']}}][name]"  id="basic-default-fullname" value=""/>
          </div>
            <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
      </div>
      
      @endif
        @endforeach
      </div>
    </form>
    </div>
  </div>
</div>

@endsection
