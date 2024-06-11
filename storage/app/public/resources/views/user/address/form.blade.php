@extends('user.layout.app')
@section('title','Address')
@push('css')
@endpush
@section('content')
@php($address = $address ?? null)
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100">

                <!-- User Content -->
                <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">

                    <!-- Address -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-50">Address</h4>
                        </div>
                        <div class="card-body">
                            <span class="text-danger">Note: Please Provide a valid UK address</span>
                            <p>
                                <span class="text-danger">Note: Start typing and then select the first line of your address, and the other fields will be filled automatically</span>
                            </p>
                            <form id="addNewAddressForm" action="{{route('user.address.store') }}" method="POST"
                                class="row gy-1 gx-2 submit_form">
                                @csrf
                                <input type="hidden" name="id" value="{{$address->id ?? ""}}">
                                <div class="col-12">
                                    <label class="form-label" for="name">Address Label</label>
                                    <input type="text" id="name" name="name" value="{{$address->name ?? ""}}"
                                        class="form-control " required placeholder="John"
                                        data-msg="Please enter your Address Name">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="modalAddressCountry">Country</label>
                                    <input type="text" id="modalAddressCountry" class="form-control " required
                                        value="United Kingdom" disabled>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="type">Type</label>
                                    @if($id != null)
                                    <select name="type" class="form-select" id="type">
                                        <option class="form-control" value="primary"
                                            {{$address->type == "primary" ? 'selected' : ''}}>Primary</option>
                                        <option class="form-control" value="secondary"
                                            {{$address->type == "secondary" ? 'selected' : ''}}>Secondary</option>
                                    </select>
                                    @else
                                    <select name="type" class="form-select" id="type">
                                        <option class="form-control" value="primary">Primary</option>
                                        <option class="form-control" value="secondary" selected>Secondary</option>
                                    </select>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="street_number">House number & Street name</label>
                                    <div id="custom-search-input">
                                        <div class="input-group">
                                            <input required id="autocomplete_search" value="{{$address->street_number ?? ''}}" name="street_number" type="text"
                                                class="form-control addressFields auto_searchh" placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="city">City<span class="text-danger">*</span></label>
                                    <input type="text" id="city" value="{{strtolower($auth->seller_address->city ?? '')}}"
                                        name="" class="form-control city" readonly required >
                                    @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="postal_code">Postal Code</label>
                                    <input type="text" id="postal_code" value="{{$address->postal_code ?? ''}}"
                                        name="" class="form-control postal_code" readonly required placeholder="99950">
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit"
                                        class="btn btn-primary me-1 mt-2 waves-effect waves-float waves-light submit_btn">Submit</button>
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
@include('user.components.google-map-api-script')
@endpush
