
@extends('user.layout.app')
@section('title','Change Interest')
@push('css')
@endpush
@section('content')

@php($address = $address ?? null)
<div class="bs-stepper-content px-0 mt-md-2">
    <div id="account-details" class="mx-md-5 content active dstepper-block" role="tabpanel" aria-labelledby="account-details-trigger">
        @if($request->role == "seller")
        <div class="alert alert-warning mt-1 alert-validation-msg" role="alert">
            <div class="alert-body d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span>Your cannot change your account type back to <strong>Buyer</strong> but you can still buy things on our platform.</span>
            </div>
        </div>
        @endif
        <div class="content-header mb-2">
            <h2 class="fw-bolder mb-75">Account Information</h2>
            <!-- <span>Enter your Saler</span> -->
        </div>
        <div class="row">
                <label for="" class="fw-bolder mb-25">Personal Info</label>
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="username">Full Name</label>
                    <input type="text" class="form-control" value="{{$auth->full_name}}" readonly>
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="username">Email</label>
                    <input type="text" class="form-control" value="{{$auth->email}}" readonly>
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="username">Date of Birth</label>
                    <input type="text" class="form-control" value="{{$auth->dob}}" readonly>
                </div>
            </div>
        <form class="pb-4 role_form" action="{{route('user.mangopay.user')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="role" value="{{$request->role}}">
            <input type="hidden" name="update_user" value="{{$request->update ?? 0}}">
            <div class="row">
                @if($request->role == 'business')
                <label for="" class="fw-bolder mb-25">Company Info</label>
                <div class="col-md-4 mb-1">
                    <label class="form-label" for="username">Company/Shop name<span class="text-danger">*</span></label>
                    <input type="text" name="company_name" value="{{$auth->store->company_name ?? ''}}" class="form-control" required placeholder="">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-4 mb-1">
                    <label class="form-label" for="username">Company/Shop Reg Nunmber<span class="text-danger">*</span></label>
                    <input type="text" name="company_no" value="{{$auth->store->company_no ?? ''}}" class="form-control" required placeholder="">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-4 mb-1">
                    <label class="form-label" for="telephone">Birthplace ( City )<span class="text-danger">*</span></label>
                    <input type="text" name="city_of_birth" value="{{$auth->store->city_of_birth ?? ''}}" class="form-control" required placeholder="">
                    @error('city_of_birth')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                @endif
                <input type="hidden" class="address_id" name="address_id" value="{{$auth->seller_address->id ?? null}}">
                <label for="address_id" class="fw-bolder mb-25">Address</label>
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="street_number">House number & Street name</label>
                    <div id="custom-search-input">
                        <div class="input-group">
                            <input required id="autocomplete_search" value="{{$auth->seller_address->street_number ?? ''}}" name="street_number" type="text"
                                class="form-control addressFields auto_searchh" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="city">City</label>
                    <input type="text" id="city" value="{{strtolower($auth->seller_address->city ?? '')}}"
                        name="" class="form-control city" readonly required >
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-3 mb-1">
                    <label class="form-label" for="postal_code">Postal Code</label>
                    <input type="text" value="{{$auth->seller_address->postal_code ?? null}}" id="postal_code" name="" class="form-control postal_code " readonly placeholder="" required>
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="">Nationality</label>
                    <select name="nationality" class="form-select select2" required>
                        <option value="">Select</option>
                        @foreach(mangopayIsoCountryCode() as $key => $counrtyCode)
                        <option value="{{$key}}" >{{$counrtyCode}}</option>
                        @endforeach
                    </select>
                </div>
              
                <div class="col-md-6 mb-1">
                    <label class="form-label" for="">Country of Residence</label>
                    <input type="text" name="country" value="United Kingdom"  readonly class="form-control " placeholder="" required >
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2 ">
                <button type="submit" class="btn btn-outline-success waves-effect submit_btn text-capitalize" >
                    Active  {{$request->role}} Account
                </button>
            </div>
        </form>
      
        
    </div>
</div>

@endsection

@push('js')
<script>

$(document).ready(function(){
    post = '{{$auth->seller_address->postal_code ?? null}}';
    locality = '{{strtolower($auth->seller_address->city ?? '')}}';
})
  
    $(document).on("change", ".addressFields", function () {
     $(".address_id").remove();   
});
$(document).on("submit", ".role_form", function (e) {
   
    e.preventDefault();
    toastr.info("Please wait your request has sent.");
    var form = $(this);
    var submit_btn = $(form).find(".submit_btn");
    $(submit_btn).prop("disabled", true);
    var data = new FormData(this);
    data.append('postal_code', post);
    data.append('city', locality);
    $(form).find(".submit_btn").prop("disabled", true);
    $.ajax({
        type: "POST",
        data: data,
        cache: !1,
        contentType: !1,
        processData: !1,
        url: $(form).attr("action"),
        async: true,
        headers: {
            "cache-control": "no-cache",
        },
        success: function (response) {
            if (response.redirect) {
                window.location = response.redirect
            }
            $(submit_btn).prop("disabled", false);
            $(submit_btn).closest("div").find(".loader").addClass("d-none");
        },
        error: function (xhr, status, error) {
            $(submit_btn).prop("disabled", false);
            if (xhr.status == 422) {
                $(form).find("div.alert").remove();
                var errorObj = xhr.responseJSON.errors;
                $.map(errorObj, function (value, index) {
                    var appendIn = $(form)
                        .find('[name="' + index + '"]')
                        .closest("div");
                    if (!appendIn.length) {
                        toastr.error(value[0]);
                    } else {
                        $(appendIn).append(
                            '<div class="alert alert-danger" style="padding: 1px 5px;font-size: 12px"> ' +
                                value[0] +
                                "</div>"
                        );
                    }
                });
                $(form).find(".submit_btn").prop("disabled", false);
            } else {
                $(form).find(".submit_btn").prop("disabled", false);
                toastr.error("Unknown Error!");
            }
        },
    });
});
</script>
@include('user.components.google-map-api-script')
@endpush
