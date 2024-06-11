@extends('user.layout.app')
@section('title','Dashboard')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100">
                
                <div class="col-xl-4 col-lg-5 col-md-5 ">
                    @include('user.components.userCard')
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    @include('user.components.action-list')
                    <div class="card">
                        <div class="card-body pt-1">
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-3">
                                            <span class="fw-bolder me-25">Full Name:</span>
                                        </div>
                                        <div class="col-9">
                                            <span >{{$auth->full_name}}</span>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-3"> 
                                            <span class="fw-bolder me-25">Email:</span>
                                        </div>
                                        <div class="col-9">
                                            <span >{{$auth->email}}</span>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-3">
                                            <span class="fw-bolder me-25">Phone:</span>
                                        </div>
                                        <div class="col-9">
                                            <span >{{$auth->phone}}</span>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#phoneNumber" class="btn btn-icon btn-icon  btn-flat-primary py-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add/Update" title="Add/Update">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </button>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-3">
                                            <span class="fw-bolder me-25">Date of Birth:</span>
                                        </div>  
                                        <div class="col-9">
                                            <span >{{$auth->dateofbirth}}</span>
                                        </div>
                                    </li>
                                    <li class="mb-75 justify-content-between d-flex">
                                        <div class="col-3">
                                            <span class="fw-bolder me-25">Status:</span>
                                        </div>
                                        <div class="col-9">
                                            <span  class="text-capitalize">{{$auth->status}}</span>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#userStatus" class="btn btn-icon btn-icon  btn-flat-primary py-0 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Update" title="Change Status">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                                
                                {{--<div class="d-flex justify-content-center pt-2">
                                    <button class="btn btn-outline-danger suspend-user waves-effect" data-bs-toggle="modal" data-bs-target="#deletedAccount">Delete Account</button>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@include('user.layout.modals.profileSetting.dob')
@include('user.layout.modals.profileSetting.email')
@include('user.layout.modals.profileSetting.phone-number')
@include('user.layout.modals.profileSetting.status')
@include('user.layout.modals.delete-account')
@endsection

@push('js')

@endpush
