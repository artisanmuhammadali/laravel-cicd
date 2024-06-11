@extends('admin.layout.app')
@section('title','Team Management')
@section('heading','Team Management')


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
                            <div class="card-header">
                                <h4 class="card-title">Admin Team</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12 order-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="">Team Members</h4>
                                                <div class="table-responsive">
                                                    <table class="table data-list-view">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. #</th>
                                                                <th>Role</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th class="float-right pr-2">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @forelse($users as $user)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td><span class="badge bg-primary">{{ $user->roles[0]->name }}</span></td>
                                                                <td>{{ $user->first_name ?? 'N/A' }}</td>
                                                                <td class="product-name">{{ $user->email ?? 'N/A' }}</td>
                                                                <td class="product-action text-right">
                                                                    <div class="btn-group">
                                                                        {{-- <a href="" title="Edit" class="btn btn-primary"><i class="feather icon-edit"></i></a> --}}
                                                                        @if($user->roles[0]->name != 'Super Admin')
                                                                        <a href="{{ route('admin.teams.remove', $user->id) }}" onclick="return confirm('Do you really want to delete this admin?')" title="Trash" class="btn btn-danger alert-confirm"><i data-feather='trash'></i></a>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class=" card">
                                            <div class="card-body">
                                                    <h4 class="">Add Team Member</h4>
                                                <form action="{{ route('admin.teams.store') }}" method="POST">
                                                    @csrf
                                                    <div class="data-items pb-3">
                                                            <div class="row">

                                                                @if (count($errors) > 0)
                                                                    <div class="col-sm-12 data-field-col">
                                                                        <div class="alert alert-danger">
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                                <div class="col-sm-12 data-field-col">
                                                                    <label for="data-name">Name</label>
                                                                    <input type="text" class="form-control" name="name" required>
                                                                </div>

                                                                <div class="col-sm-12 data-field-col">
                                                                    <label for="data-name">Email</label>
                                                                    <input type="email" class="form-control" name="email" required>
                                                                </div>

                                                                <div class="col-sm-12 data-field-col">
                                                                    <label for="data-name">Select role</label>

                                                                    <select class="form-control form-select" name="role" required>
                                                                        <option value="" hidden>Select a role</option>
                                                                        @foreach($roles as $role)
                                                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-12 mt-1 ">
                                                                    <h5 class="alert alert-warning p-1"><i data-feather="alert-circle"></i> Assign the role to team member as per permissions attached to designated role in the roles panel.</h5>
                                                                    <div class=" row">
                                                                        <div class="col-12 d-flex justify-content-end">
                                                                            <button class="btn btn-primary me-50">Add Data</button>
                                                                            <a class="btn btn-danger cancel-data-btn text-white">Cancel</a>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                            </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>




@endsection

