@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
@include('admin.components.timepikerStyle')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="row-grouping-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <h4 class="card-title">Filter</h4>
                                    </div>
                                    <div class="card-body px-3">
                                        <form method="GET" action="{{route('admin.dashboard')}}">
                                            <div class="row">
                                                <div class="col-md-8 mb-2">
                                                    <div class="form-group">
                                                        <label> Date</label>
                                                        <input type="text" name="date" id="fp-range"
                                                            class="form-control flatpickr-range  flatpickr-input"
                                                            placeholder="YYYY-MM-DD" readonly="readonly"
                                                            value="{{$date ?? ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <button type="submit" class="btn btn-primary ">
                                                        Filter
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <h4 class="card-title">Users</h4>
                                        <div>
                                            <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="users">
                                                <i data-feather='file-text'></i>
                                            </button>
                                            <input type="hidden" value="{{json_encode($users)}}" id="users"> 
                                        </div>
                                    </div>
                                    <div class="card-body statistics-body">
                                        <div class="row">
                                            <div class="col-sm-3 col-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row justify-content-start">
                                                    <div class="avatar bg-light-primary me-2">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-users font-medium-5">
                                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <p class="card-text font-small-3 mb-0">Sellers</p>
                                                        <h4 class="fw-bolder mb-0">{{ $sellers }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row justify-content-start">
                                                    <div class="avatar bg-light-info me-2">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-users font-medium-5">
                                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <p class="card-text font-small-3 mb-0">Buyers</p>
                                                        <h4 class="fw-bolder mb-0">{{ $buyers }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row justify-content-start">
                                                    <div class="avatar bg-light-danger me-2">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-users font-medium-5">
                                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <p class="card-text font-small-3 mb-0">Business</p>
                                                        <h4 class="fw-bolder mb-0">{{ $both }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <div class="d-flex flex-row justify-content-start">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <img width="25px"
                                                                src="{{ asset('images/badges/verifiedSeller.svg') }}"
                                                                alt="verified" title="verified">
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <p class="card-text font-small-3 mb-0">Verified Users</p>
                                                        <h4 class="fw-bolder mb-0">{{ $verified }}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                        
                    </div>
                </div>
        
</div>
<div class="row">
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Liquidity Rate of Collections</h4>
                <div>
                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="liquidity-rate-of-collections">
                        <i data-feather='file-text'></i>
                    </button>
                    <input type="hidden" value="{{json_encode($liquidityArr)}}" id="liquidity-rate-of-collections"> 
                </div>
            </div>
            <div class="card-body">
                <div style="height:275px">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div><canvas class="doughnut-chart-ex1 chartjs chartjs-render-monitor" data-height="275" width="425"
                        height="343" style="display: block; height: 275px; width: 340px; min-height: 240px; min-width:240px;"></canvas>
                </div>
                <div class="d-flex justify-content-between mt-3 mb-1">
                    <div class="d-flex align-items-center">
                        <i data-feather='codesandbox' class="  text-success"></i>
                        <span class="fw-bolder ms-75 me-50">Total Collections</span>
                        <span>{{$liquidity->total_no}}</span>
                    </div>
                </div>
                <!-- <div class="d-flex justify-content-between mb-1">
                    <div class="d-flex align-items-center">
                        <i data-feather='archive' class="  text-primary"></i>
                        <span class="fw-bolder ms-75 me-50">Pending Collection</span>
                        <span>{{$liquidity->pending_no}} ({{$liquidity->pending_per}} %)</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Convert to Transaction</span>
                        <span>{{$liquidity->convert_no}} ({{$liquidity->convert_per}} %)</span>
                    </div>
                </div> -->
                <div class="mt-50">
                    <div class="d-flex align-items-center">
                        <span class="fw-bolder me-50">Active Collection</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Single</span>
                        <span>{{$single_liquidity->active_no}} ({{$single_liquidity->active_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Sealed</span>
                        <span>{{$sealed_liquidity->active_no}} ({{$sealed_liquidity->active_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Completed</span>
                        <span>{{$completed_liquidity->active_no}} ({{$completed_liquidity->active_per}} %)</span>
                    </div>
                </div>
                <div class="mt-50">
                    <div class="d-flex align-items-center">
                        <span class="fw-bolder me-50">Inactive Collection</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Single</span>
                        <span>{{$single_liquidity->inactive_no}} ({{$single_liquidity->inactive_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Sealed</span>
                        <span>{{$sealed_liquidity->inactive_no}} ({{$sealed_liquidity->inactive_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Completed</span>
                        <span>{{$completed_liquidity->inactive_no}} ({{$completed_liquidity->inactive_no}} %)</span>
                    </div>
                </div>
                <div class="mt-50">
                    <div class="d-flex align-items-center">
                        <span class="fw-bolder me-50">Converted to Transaction</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Single</span>
                        <span>{{$single_liquidity->convert_no}} ({{$single_liquidity->convert_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Sealed</span>
                        <span>{{$sealed_liquidity->convert_no}} ({{$sealed_liquidity->convert_per}} %)</span>
                    </div>
                    <div class="d-flex align-items-center ms-75">
                        <i data-feather='trending-up' class="  text-warning"></i>
                        <span class="fw-bolder ms-75 me-50">Completed</span>
                        <span>{{$completed_liquidity->convert_no}} ({{$completed_liquidity->convert_per}} %)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">MTG</h4>
                <div>
                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="mtg-catalouge">
                        <i data-feather='file-text'></i>
                    </button>
                    <input type="hidden" value="{{json_encode($mtg)}}" id="mtg-catalouge"> 
                </div>
            </div>
            <div class="card-body statistics-body">
                <div class="row">
                    <div class="col-xl-4  col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-primary me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-trending-up avatar-icon">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Total</p>
                                <h4 class="fw-bolder mb-0">{{ $products }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4  col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-info me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>

                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Single</p>
                                <h4 class="fw-bolder mb-0">{{ $single }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4  col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Sealed</p>
                                <h4 class="fw-bolder mb-0">{{ $sealed }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-success me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Complete</p>
                                <h4 class="fw-bolder mb-0">{{ $completed }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Special</p>
                                <h4 class="fw-bolder mb-0">{{ $special }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Expansion</p>
                                <h4 class="fw-bolder mb-0">{{ $expansion }}</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">Orders</h4>
                <div>
                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="orders">
                        <i data-feather='file-text'></i>
                    </button>
                    <input type="hidden" value="{{json_encode($order)}}" id="orders"> 
                </div>
            </div>
            <div class="card-body statistics-body">
                <div class="row">
                    <div class="col-xl-4 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-primary me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-trending-up avatar-icon">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Total</p>
                                <h4 class="fw-bolder mb-0">{{ $orders }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-info me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>

                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Pending</p>
                                <h4 class="fw-bolder mb-0">{{ $order_pending }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 col-12">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-success me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Completed</p>
                                <h4 class="fw-bolder mb-0">{{ $order_completed }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-primary me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Dispatched</p>
                                <h4 class="fw-bolder mb-0">{{ $order_dispatched }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Cancelled</p>
                                <h4 class="fw-bolder mb-0">{{ $order_cancelled }}</h4>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 mt-2 col-sm-4 col-12 mb-2 mb-sm-0">
                        <div class="d-flex flex-row justify-content-start">
                            <div class="avatar bg-light-danger me-2">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-box avatar-icon">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="my-auto">
                                <p class="card-text font-small-3 mb-0">Refunded</p>
                                <h4 class="fw-bolder mb-0">{{ $order_refunded }}</h4>
                            </div>
                        </div>
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

@push('js')
@include('admin.components.export-pdf-excel')

<!-- <script>
    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: '{{route('admin.user.inactive.command')}}',
        });
    })
</script> -->
@include('admin.components.timepikerScript')
    <script src="{{ asset('admin/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ asset('admin/js/scripts/charts/chart-chartjs.js') }}"></script>
    <script>
        var primaryColorShade = '#836AF9',
    yellowColor = '#ffe800',
    successColorShade = '#28dac6',
    warningColorShade = '#ffe802',
    warningLightColor = '#FDAC34',
    infoColorShade = '#299AFF',
    greyColor = '#4F5D70',
    blueColor = '#2c9aff',
    blueLightColor = '#84D0FF',
    greyLightColor = '#EDF1F4',
    tooltipShadow = 'rgba(0, 0, 0, 0.25)',
    lineChartPrimary = '#666ee8',
    lineChartDanger = '#ff4961',
    labelColor = '#6e6b7b',
    grid_line_color = 'rgba(200, 200, 200, 0.2)';

        let doughnutChartEx = $('.doughnut-chart-ex1');

        // Doughnut Chart
        // --------------------------------------------------------------------
        if (doughnutChartEx.length) {
            var doughnutExample = new Chart(doughnutChartEx, {
                type: 'doughnut',
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    responsiveAnimationDuration: 500,
                    cutoutPercentage: 60,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var label = data.datasets[0].labels[tooltipItem.index] || '',
                                    value = data.datasets[0].data[tooltipItem.index];
                                var output = ' ' + label + ' : ' + value + ' %';
                                return output;
                            }
                        },
                        // Updated default tooltip UI
                        shadowOffsetX: 1,
                        shadowOffsetY: 1,
                        shadowBlur: 8,
                        shadowColor: tooltipShadow,
                        backgroundColor: window.colors.solid.white,
                        titleFontColor: window.colors.solid.black,
                        bodyFontColor: window.colors.solid.black
                    }
                },
                data: {
                    datasets: [{
                        labels: ['Pending Collection', 'Convert To Transaction'],
                        data: [ {{$liquidity->pending_per}} , {{$liquidity->convert_per}} ] ,
                        backgroundColor: [primaryColorShade, warningLightColor],
                        borderWidth: 0,
                        pointStyle: 'rectRounded'
                    }]
                }
            });
        }

    </script>
@endpush
