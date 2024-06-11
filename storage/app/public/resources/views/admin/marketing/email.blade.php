@extends('admin.layout.app')
@section('title','Marketing Email')
@push('css')
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title text-capitalize">Email Marketing</h4>
                            </div>
                            <div class="card-body">
                                 <form action="{{route('admin.marketing.send')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-4 mt-5">
                                        <div class="col-md-4 col-sm-6">
                                            <label class="fw-bolder">Users</label>
                                            <select name="newsletter" class="form-select newsletter">
                                                <option value="all">All Users</option>
                                                <option value="on">Only Marketing Users</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mt-sm-0 mt-1">
                                            <label class="fw-bolder">Status</label>
                                            <select name="status" class="form-select">
                                                <option selected value="">Open this select menu</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="locked">Locked</option>
                                                <option value="on-holiday">On Holiday</option>
                                                <option value="ban">Ban</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mt-md-0 mt-1">
                                            <label class="fw-bolder">Referral Users</label>
                                            <select name="referal_type" class="form-select">
                                                <option selected value="">Open this select menu</option>
                                                @foreach($user_referral_types as $referral_type);
                                                <option class="" value="{{$referral_type->name}}">{{$referral_type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6  mt-1 role_div">
                                        <label class="fw-bolder">Role</label>
                                            <select name="role" class="form-select role_check">
                                                <option selected value="">Open this select menu</option>
                                                <option value="buyer">Buyer</option>
                                                <option value="seller">Seller</option>
                                                <option value="business">Business</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mt-1 kyc_div">
                                            <label class="fw-bolder">KYC/KYB</label>
                                            <select name="unverified" class="form-select kyc_check">
                                                <option selected value="">Open this select menu</option>
                                                <option class="" value="kyc">KYC Unverified</option>
                                                <option class="" value="kyc_ver">KYC verified</option>
                                                <option class="" value="kyb">KYB Unverified</option>
                                                <option class="" value="kyb_ver">KYB verified</option>
                                            </select>
                                        </div>
                                        
                                        
                                        <div class="col-12 mt-2">
                                            <label class="fw-bolder">Subject</label>
                                            <input type="text" class="form-control" name="subject" required>
                                            @error('subject')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <label class="fw-bolder">Body</label>
                                            <textarea name="body" id="editor" class="editor"></textarea>
                                            @error('body')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <label class="fw-bolder">Preview</label>
                                            <div class="card text-start">
                                                <div class="card-body">
                                                    @include('admin.marketing.preview')
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary m-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('admin.components.ckeditor2')

<script>
    $(document).ready(function(){
       
    })
    $(document).on('change','.newsletter',function(){
        let valu = $(this).val();
        console.log(valu);
        if(valu == 'on'){
            $('.btn_div').removeClass('d-none');
        }
        else{
            $('.btn_div').addClass('d-none');
        }
    })

    $(document).on('change','.kyc_check',function(){
        let valuee = $(this).val();
        toggleDiv('role_div',valuee)
    })

    $(document).on('change','.role_check',function(){
        let valuee = $(this).val();
        toggleDiv('kyc_div',valuee)
    })

    function toggleDiv(clas,valuee)
    {
        if(valuee)
        {
            $('.'+clas).hide();
        }
        else{
            $('.'+clas).show()
        }
    }
</script>
@endpush


