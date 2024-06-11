@extends('user.layout.app')
@section('title','Referral Users')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="invoice-preview-wrapper d-flex justify-content-center">
            <div class="row invoice-preview w-100">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Referred Users</h4>
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light py-1" data-bs-toggle="modal" data-bs-target="#sendInvite">Invite Users</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Total Referral Credit</th>
                                            <th>Register On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td>
                                                <img src="{{$item->main_image}}" class="me-75" height="20" width="20" alt="Angular">
                                                <span class="fw-bold"><a href="{{route('profile.index',$item->user_name)}}">{{$item->user_name}}</a></span>
                                            </td>
                                            <td>
                                                £ {{getRefelUserAmount($item->id, $auth->id)}}
                                            </td>
                                            <td>{{$item->created_at->format('Y/m/d')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@include('user.layout.modals.referral-link')
@endsection

@push('js')

@endpush
