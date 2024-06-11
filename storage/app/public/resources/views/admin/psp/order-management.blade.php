@extends('admin.layout.app')
@section('title','Dashboard')
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
            <form action="{{route('admin.mtg.cms.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header card-header-primary card-header-icon">
                                <h5 class="card-title">Payment Service Provider Setting</h5>
                                <hr>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>VFS Platform Fee ( % )</label>
                                            <input type="number" step="0.01" min="0.01" name="vfs_platform_fee" class="form-control"
                                                value="{{$setting['vfs_platform_fee'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Referral Credit Percentage ( % )</label>
                                            <input type="number" step="0.01" min="0.01" name="referral_credit_percent" class="form-control"
                                                value="{{$setting['referral_credit_percent'] ?? ''}}">
                                        </div>
                                    </div>
                                    {{--<div class="col-md-3">
                                        <div class="form-group">
                                            <label>Referral Credit Max Limit</label>
                                            <input type="number" name="referral_credit_limit" class="form-control"
                                                value="{{$setting['referral_credit_limit'] ?? ''}}">
                                        </div>
                                    </div>--}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>VAT Percentage ( % )</label>
                                            <input type="number" name="vat_percentage"  class="form-control"
                                                value="{{$setting['vat_percentage'] ?? '0'}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Submit">submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
