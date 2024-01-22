@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Settings')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{__("Branch")}}/</span> {{__("Create")}}</h4>

<!-- Basic Layout -->
<div class="row">
  <div class="col-xl-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__("Branch Details")}}</h5>
      </div>
      <div class="card-body">
        <label class="form-label" for="basic-default-fullname"></label>
        <form action="{{ route('branch.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            @if ($errors->has('name'))
            <div class="alert alert-danger">
              {{ $errors->first('name') }}
            </div>
            @endif
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Name")}}</label>
            <input type="text" class="form-control" name="name" id="basic-default-fullname" value="" />
          </div>
          <div class="mb-3">
            @if ($errors->has('country'))
            <div class="alert alert-danger">
              {{ $errors->first('country') }}
            </div>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Country")}}</label>
            <input type="text" class="form-control" name="country" id="basic-default-fullname" value="" />
          </div>
          <div class="mb-3">
            @if ($errors->has('city'))
            <div class="alert alert-danger">
              {{ $errors->first('city') }}
            </div>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("City")}}</label>
            <input type="text" class="form-control" name="city" id="basic-default-fullname" value="" />
          </div>
          <div class="mb-3">
            @if ($errors->has('post_code'))
            <div class="alert alert-danger">
              {{ $errors->first('post_code') }}
            </div>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Postal Code")}}</label>
            <input type="text" class="form-control" name="post_code" id="basic-default-fullname" value="" />
          </div>
          <div class="mb-3">
            @if ($errors->has('address1'))
            <div class="alert alert-danger">
              {{ $errors->first('address1') }}
            </div>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">{{__("Address")}} 1</label>
            <input type="text" class="form-control" name="address1" id="basic-default-fullname" value="" />
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-default-branch_title">Branch Title</label>
            <input type="text" class="form-control" name="branch_title" id="basic-default-branch_title" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-branch_url">Branch URL</label>
            <input type="text" class="form-control" name="branch_url" id="basic-default-branch_url" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_1">Offer Line 1</label>
            <input type="text" class="form-control" name="pdf_offer_line_1" id="basic-default-pdf_offer_line_1" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_2">Offer Line 2</label>
            <input type="text" class="form-control" name="pdf_offer_line_2" id="basic-default-pdf_offer_line_2" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_3">Offer Line 3</label>
            <input type="text" class="form-control" name="pdf_offer_line_3" id="basic-default-pdf_offer_line_3" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_4">Offer Line 4</label>
            <input type="text" class="form-control" name="pdf_offer_line_4" id="basic-default-pdf_offer_line_4" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_5">Offer Line 5</label>
            <input type="text" class="form-control" name="pdf_offer_line_5" id="basic-default-pdf_offer_line_5" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-pdf_offer_line_6">Offer Line 6</label>
            <input type="text" class="form-control" name="pdf_offer_line_6" id="basic-default-pdf_offer_line_6" value="" />
          </div>


          <div class="mb-3">
            <label class="form-label" for="basic-default-tax_number">{{ __('pdf.tax_number') }}</label>
            <input type="text" class="form-control" name="tax_number" id="basic-default-tax_number" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-vat_id">{{ __('pdf.vat_id') }}</label>
            <input type="text" class="form-control" name="vat_id" id="basic-default-vat_id" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-register">{{ __('pdf.register') }}</label>
            <input type="text" class="form-control" name="register" id="basic-default-register" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-iban">{{ __('pdf.iban') }}</label>
            <input type="text" class="form-control" name="iban" id="basic-default-iban" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-bic">{{ __('pdf.bic') }}</label>
            <input type="text" class="form-control" name="bic" id="basic-default-bic" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-phone">{{ __('pdf.phone') }}</label>
            <input type="text" class="form-control" name="phone" id="basic-default-phone" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fax">{{ __('pdf.invoice_fax') }}</label>
            <input type="text" class="form-control" name="fax" id="basic-default-fax" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-mail">{{ __('pdf.invoice_email') }}</label>
            <input type="text" class="form-control" name="mail" id="basic-default-mail" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-web">{{ __('pdf.invoice_web') }}</label>
            <input type="text" class="form-control" name="web" id="basic-default-web" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-bank_name">{{ __('pdf.bank_name') }}</label>
            <input type="text" class="form-control" name="bank_name" id="basic-default-bank_name" value="" />
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-bank_address">{{ __('pdf.invoice_bank_address') }}</label>
            <input type="text" class="form-control" name="bank_address" id="basic-default-bank_address" value="" />
          </div>
          
          <button type="submit" class="btn btn-primary">{{__("Add")}}</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

@endsection