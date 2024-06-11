
@extends('user.layout.app')
@section('title','Change Interest')
@push('css')
@endpush
@section('content')

<div class="bs-stepper-content px-0 mt-md-2">
    <div id="account-details" class="mx-md-5 content active dstepper-block" role="tabpanel" aria-labelledby="account-details-trigger">
        <div class="content-header mb-2">
            <h2 class="fw-bolder mb-75">Best practices</h2>
            <p>
                When submitting a document, it is very important that the user respects the best practices below to ensure that the document can be read and verified.

                If any of the guidelines are not respected, it may result in an error or delay in processing the document.

                The document should be:
            </p>
            <ul>
                <li>
                    Passport or Driving license
                </li>
                <li>
                    Valid and up to date
                </li>
                <li>
                    For a person aged over 18
                </li>
                <li>
                    In color and a photo (rather than a liquid scan)
                </li>
                <li>
                    Between 32KB and about 7MB (max. 10MB when encoded)
                </li>
                <li>
                    In one of the accepted formats: PNG, PDF, JPG, JPEG
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center">
            <div class="loader d-none position-absolute" style="top: 200px;">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <form class="pb-4 role_form" action="{{route('user.mangopay.submit.kyc')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @php(list($k , $check)=getFailedKyc('photo_id_scan'))
            @if(!$k || $check)
            <input type="hidden" name="type[photo_id_scan]" value="IDENTITY_PROOF">
            <div class="col-md-6 mb-1">
                <label class="form-label" for="photo_id_scan">Add a Photo<span class="text-danger">*</span></label>
                <p class="mb-0 sm-text">Must upload a valid photo ID scan</p>
                <input type="file"  id="photo_id_scan" name="file[photo_id_scan]" class="form-control" placeholder="" accept="image/jpg, image/jpeg, image/png, application/pdf,"  required>
                @error('photo_id_scan')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            @endif
            @php(list($k , $check)=getFailedKyc('registration_proof'))
            @if($auth->role == "business" && (!$k || $check))
            <input type="hidden" name="type[registration_proof]" value="REGISTRATION_PROOF">
            <div class="col-md-6 mb-1">
                <label class="form-label" for="registration_proof">Add a Photo<span class="text-danger">*</span></label>
                <p class="mb-0 sm-text">Registration proof of the legal entity</p>
                <input type="file"  id="registration_proof" name="file[registration_proof]" class="form-control" accept="image/jpg, image/jpeg, image/png, application/pdf," placeholder="" required>
                @error('registration_proof')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            @endif
            @php(list($k , $check)=getFailedKyc('article_of_association'))
            @if($auth->role == "business" && (!$k || $check))
            <input type="hidden" name="type[article_of_association]" value="ARTICLES_OF_ASSOCIATION" >
            <div class="col-md-6 mb-1">
                <label class="form-label" for="article_of_association">Add a Photo<span class="text-danger">*</span></label>
                <p class="mb-0 sm-text">Articles of association of the legal entity</p>
                <input type="file"  id="article_of_association" name="file[article_of_association]" class="form-control" placeholder="" accept="image/jpg, image/jpeg, image/png, application/pdf,"required>
                @error('article_of_association')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            @endif
            <div class="col-md-6 mb-1">
                <label class="form-label" for="">Nationality</label>
                <select name="nationality" class="form-select select2">
                    @foreach(mangopayIsoCountryCode() as $key => $counrtyCode)
                    <option value="{{$key}}" {{$key == 'GB' ? 'selected' : ''}}>{{$counrtyCode}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-end mt-2 ">
                <button type="submit" class="btn btn-outline-success waves-effect submit_btn" >
                    Submit Kyc
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
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
    $(form).find(".submit_btn").prop("disabled", true);
    $(".loader").removeClass("d-none");
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
            if (response.error) {
                toastr.error(response.error);
            }
            if (response.redirect) {
                window.location = response.redirect
            }
            $(submit_btn).prop("disabled", false);
            $(".loader").addClass("d-none");
        },
        error: function (xhr, status, error) {
            $(".loader").addClass("d-none");
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
                toastr.error("Please Check Your KYC and Try Again!");
            }
        },
    });
});
</script>
@endpush
