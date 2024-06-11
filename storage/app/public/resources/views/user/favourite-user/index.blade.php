@extends('user.layout.app')
@section('title','Favourite Users')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Favourite Users</h4>
                        </div>
                        <div class="card-body">
                            @if(count($list) <= 0)
                            <div class="row text-center">
                                <p class="text-danger">No user(s) in favourite</p>
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Favourite On</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $item)
                                        <tr>
                                            <td>
                                                <a href="{{route('profile.index',$item->user->user_name)}}">
                                                    <img src="{{$item->user->main_image}}" class="me-75" height="20" width="20" alt="Angular">
                                                    <span class="fw-bold">{{$item->user->user_name}}</span>
                                                </a>
                                            </td>
                                            <td>{{$item->created_at->format('Y/m/d')}}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                        <button class="btn btn-outline-danger waves-effect" onclick="deleteAlert('{{route('user.favourite.destroy',$item->id)}}')" title="Remove"><i data-feather='trash'></i></button>
                                                </div>
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
