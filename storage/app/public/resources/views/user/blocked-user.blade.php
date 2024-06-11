@extends('user.layout.app')
@section('title','Blocked Users')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center overflow-hidden justify-content-center">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Blocked Users</h4>
                        </div>
                        <div class="card-body">
                            @if(count($list) <= 0)
                            <div class="row text-center">
                                <p class="text-danger">No Blocked User(s)</p>
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Blocked On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td>
                                                <img src="{{$item->user->main_image ?? ''}}" class="me-75" height="20" width="20" alt="Profile">
                                                <span class="fw-bold"><a target="_blank" href="{{route('profile.index',$item->user->user_name)}}">{{$item->user->user_name ?? ''}}</a></span>
                                            </td>
                                            <td>{{$item->created_at->format('Y/m/d')}}</td>
                                            <td>
                                                <a class="btn btn-outline-danger waves-effect" href="{{route('user.block.destroy',$item->id)}}" title="Remove">
                                                            <i data-feather='trash'></i>
                                                        </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
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
