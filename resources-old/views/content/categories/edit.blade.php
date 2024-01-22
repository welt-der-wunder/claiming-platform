@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Category')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("Category")}}/</span> {{__("Edit")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("Category Details")}}</h5>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bs-tab" data-bs-toggle="tab" data-bs-target="#bs" type="button"
              role="tab" aria-controls="bs" aria-selected="true">BS</button>
          </li>
          @foreach (getAvailableLanguages() as $lang)
          @if (!$lang['exclude'])
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="{{$lang['code']}}-tab" data-bs-toggle="tab" data-bs-target="#{{$lang['code']}}"
              type="button" role="tab" aria-controls="{{$lang['code']}}"
              aria-selected="false">{{strtoupper($lang['code'])}}</button>
          </li>
          @endif
          @endforeach

        </ul>
      </div>
      <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
              <input type="text" class="form-control" name="name" id="basic-default-fullname"
                value="{{$category->name}}" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-parent_id">{{__("Parent Category")}}</label>

              <select id="parent_id" class="form-select" name="parent_id">
                <option value="" {{ !$category->parent_id ? "selected" : ''}}>{{__("Select Category")}}</option>
                @foreach ($categories as $cat)
                @if ($cat->id != $category->id)


                <option value={{$cat->id}} {{($cat->id==$category->parent_id)?
                  'selected':''}}>{{$cat->parent_id ? "---".$cat->name : $cat->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">{{__("Image")}}</label>
              @if($category->image)
              <input class="form-control" type="file" name="image" id="formFile">
              <div class="mb-2">
                <img class="mt-2 avatar avatar-lg pull-up" src="{{ asset('storage/'.$category->image->image_url) }}"
                  alt="Category Image" id="category-image">
              </div>
              @else
              <input class="form-control" type="file" name="image" id="formFile">
              @endif
            </div>
            <div class="mb-3">
              <label class="form-label">{{__("Active")}}</label>
              <br>
              <input type="checkbox" class="form-check-input" name="is_active" value="1" @if($category->is_active)
              {{'checked'}} @endif />
            </div>
            <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
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
              <input type="text" class="form-control" name="translation[{{$lang['code']}}][name]"
                id="basic-default-fullname"
                value="{{ isset($category->translation[$lang['code']]['name']) ? $category->translation[$lang['code']]['name'] : '' }}" />
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
<script>
  // Get the file input element and the product image element
  const fileInput = document.getElementById('formFile');
  const categoryImage = document.getElementById('category-image');
  
  // Add an event listener to the file input
  fileInput.addEventListener('change', function() {
    // Get the selected file and create a URL for it
    const file = fileInput.files[0];
    const url = URL.createObjectURL(file);
    
    // Update the product image element with the new URL
    categoryImage.src = url;
  });
</script>
@endsection