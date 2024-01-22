@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Mail Template')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("Settings")}}/</span> {{__("Edit Mail Template")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("Mail Templates")}} / {{$status->name}}</h5>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          @php
            $i = 0;
          @endphp
          @foreach (getAvailableLanguages() as $lang)
          
          @php
            $class="";
            if($i==0){
              $class="active";
            }
          @endphp
          <li class="nav-item" role="presentation">
            <button class="nav-link {{ $class }}" id="{{$lang['code']}}-tab" data-bs-toggle="tab" data-bs-target="#{{$lang['code']}}" type="button" role="tab" aria-controls="{{$lang['code']}}" aria-selected="{{ $i == 0 ? 'true' : 'false'}}">{{strtoupper($lang['code'])}}</button>
          </li>
        
          @php
            $i++;
          @endphp
          @endforeach
          
        </ul>
      </div>
      @php
        //dd($_GET['branch']);
      @endphp
        <div class="card-body">
          <form action="" method="GET" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Branch")}}</label>
            <select id="defaultSelect" class="form-select" name="branch" onchange="this.form.submit()">
              <option value="default">Default</option>
              @foreach ($branches as $branch)
              @php
                $selected = "";
                if(isset($_GET['branch']) && $_GET['branch'] == $branch->id) $selected = 'selected';
              @endphp
              <option value="{{$branch->id}}" {{ $selected}}>{{$branch->name}}</option>
              @endforeach
            </select>
          </div>
        </form>

        @php
          $selectedBranch = "default";
          if(isset($_GET['branch'])) $selectedBranch = $_GET['branch']
        @endphp

          <form action="{{ route('templates-update', ['id' => $status->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
              <div class="card-body tab-content" id="myTabContent">
              
                <input type="hidden" name="branch" value="{{ $selectedBranch }}" />
            @php
              $i = 0;
            @endphp
            @foreach (getAvailableLanguages() as $lang)

              
            <div class="tab-pane fade {{$i == 0 ? 'show active' : ''}}" id="{{$lang['code']}}" role="tabpanel" aria-labelledby="{{$lang['code']}}-tab">
              <div class="mb-3">
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                  @endif
                </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("Mail subject")}}</label>
                <input type="text" class="form-control" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][subject]"  id="basic-default-fullname" value="{{ isset($status->mail_template[$lang['code']][$selectedBranch]['subject']) ? $status->mail_template[$lang['code']][$selectedBranch]['subject'] : '' }}"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("From")}}</label>
                <input type="text" class="form-control" placeholder="TIM - My Business Support" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][from]"  id="basic-default-fullname" value="{{ isset($status->mail_template[$lang['code']][$selectedBranch]['from']) ? $status->mail_template[$lang['code']][$selectedBranch]['from'] : '' }}"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("TO")}} <span style="font-size:9px">If not entered mail will be sent to customer</span></label>
                <input type="text" class="form-control" placeholder="tim@mybusiness-support.com, info@mybusiness-support.com" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][to]"  id="basic-default-fullname" value="{{ isset($status->mail_template[$lang['code']][$selectedBranch]['to']) ? $status->mail_template[$lang['code']][$selectedBranch]['to'] : '' }}"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("CC")}}</label>
                <input type="text" class="form-control" placeholder="tim@mybusiness-support.com, info@mybusiness-support.com" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][cc]"  id="basic-default-fullname" value="{{ isset($status->mail_template[$lang['code']][$selectedBranch]['cc']) ? $status->mail_template[$lang['code']][$selectedBranch]['cc'] : '' }}"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">{{__("Bcc")}}</label>
                <input type="text" class="form-control" placeholder="tim@mybusiness-support.com, info@mybusiness-support.com" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][bcc]"  id="basic-default-fullname" value="{{ isset($status->mail_template[$lang['code']][$selectedBranch]['bcc']) ? $status->mail_template[$lang['code']][$selectedBranch]['bcc'] : '' }}"/>
              </div>
                <div class="mb-3">
                  <label class="form-label" for="basic-default-message">{{__("Content")}}</label>
                  <textarea id="basic-default-message" style="height: 180px" name="mail_template[{{$lang['code']}}][{{$selectedBranch}}][content]" class="form-control" placeholder="{{__("Add content")}} ...">{{ isset($status->mail_template[$lang['code']][$selectedBranch]['content']) ? $status->mail_template[$lang['code']][$selectedBranch]['content'] : '' }}</textarea>
                </div>

              
                <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
          </div>
          @php
            $i++;
          @endphp
            @endforeach
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
