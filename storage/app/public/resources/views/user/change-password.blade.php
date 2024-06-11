@extends('user.layout.app')
@section('title','Change Password')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden">
            <div class="row w-100 ">
                <div class="col-xl-4 col-lg-5 col-md-5 ">
                    @include('user.components.userCard')
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 ">
                    @include('user.components.action-list')
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Change Password</h4>
                        </div>
                        <div class="card-body pt-1">
                            <form  action="{{route('user.profile.change.password')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="account-old-password">Current password</label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="password" class="form-control" id="account-old-password" name="current_password" placeholder="Enter current password" data-msg="Please current password">
                                            <div class="input-group-text cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </div>
                                        </div>
                                        @error('current_password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="account-new-password">New Password</label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="password" id="account-new-password" name="password" class="form-control" placeholder="Enter new password">
                                            <div class="input-group-text cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </div>
                                        </div>
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="account-retype-new-password">Retype New Password</label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="password" class="form-control" id="account-retype-new-password" name="password_confirmation" placeholder="Confirm your new password">
                                            <div class="input-group-text cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-bolder">Password requirements:</p>
                                        <ul class="ps-1 ms-25">
                                            <li class="mb-50">Minimum of 8 characters in length, with more characters being better.</li>
                                            <li class="mb-50">At least one lowercase and one uppercase character.</li>
                                            <li>At least one number, symbol, or whitespace character.</li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1 mt-1 waves-effect waves-float waves-light" title="Save">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('js')

@endpush
