@extends('admin.layout.app')
@section('title','User Detail')
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
            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-header mb-2">
                            <div class="position-relative {{$user->deleted_at == null ? 'bg-primary' : 'bg-danger'}} bg-primary pt-5 pb-2">
                                <div class="profile-img-container d-flex align-items-center d-flex justify-content-between me-sm-5 me-1">
                                    <div class="d-flex">
                                        <div class="profile-img">
                                            <img src="{{$user->main_image}}" class="rounded img-fluid ms-1" alt="Card image" height="100" width="100">
                                        </div>
                                        <div class="profile-title ms-3">
                                            <h2 class="text-white text-capitalize">{{$user->fullname ? $user->fullname : ""}}</h2>
                                            <p class="text-white text-capitalize mb-25">{{$user->role}}</p>
                                        </div>
                                    </div>
                                    @if($user->deleted_at == null)
                                        <button type="button" class="btn btn-warning px-2 py-1 btn-flat-warning waves-effect" data-bs-toggle="modal" data-bs-target="#editUser" title="Edit User">
                                            <i data-feather='edit'></i> <span class='d-sm-flex d-none'>Update User</span>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-success px-2 py-1 btn-flat-success waves-effect" data-bs-toggle="modal" data-bs-target="#deleteUser" title="Restore User">
                                            <i data-feather='edit'></i>Restore User
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="profile-header-nav px-1">
                                <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                    <button class="btn btn-icon navbar-toggler waves-effect waves-float waves-light"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                        aria-controls="navbarSupportedContent" aria-expanded="false"
                                        aria-label="Toggle navigation">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-align-justify font-medium-5">
                                            <line x1="21" y1="10" x2="3" y2="10"></line>
                                            <line x1="21" y1="6" x2="3" y2="6"></line>
                                            <line x1="21" y1="14" x2="3" y2="14"></line>
                                            <line x1="21" y1="18" x2="3" y2="18"></line>
                                        </svg>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                                            <ul class="nav nav-pills mb-0">
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.detail',[$id , 'info'])) active @endif" href="{{route('admin.user.detail',[$id , 'info'])}}">
                                                        <span class="d-md-block">Info</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.collections',[$id , 'collection'])) active @endif" href="{{route('admin.user.collections',[$id , 'collection'])}}">
                                                        <span class="d-md-block">Collection</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.orders',[$id , 'orders'])) active @endif" href="{{route('admin.user.orders',[$id , 'orders'])}}">
                                                        <span class="d-md-block">Orders</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.transactions',[$id , 'transaction'])) active @endif" href="{{route('admin.user.transactions',[$id , 'transaction'])}}">
                                                        <span class="d-md-block">Transactions</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.detail',[$id , 'wallets'])) active @endif" href="{{route('admin.user.detail',[$id , 'wallets'])}}">
                                                        <span class="d-md-block">Wallets</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.detail',[$id , 'user-stats'])) active @endif" href="{{route('admin.user.detail',[$id , 'user-stats'])}}">
                                                        <span class="d-md-block">User Stats</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.detail',[$id,'conversation'])) active @endif" href="{{route('admin.user.detail',[$id,'conversation'])}}">
                                                        <span class="d-md-block">Conversations</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.referal',[$id,'referal'])) active @endif" href="{{route('admin.user.referal',[$id,'referal'])}}">
                                                        <span class="d-none d-md-block">Referral To</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.reviews',[$id,'reviews'])) active @endif" href="{{route('admin.user.reviews',[$id,'reviews'])}}">
                                                        <span class="d-none d-md-block">Reviews</span>
                                                    </a>
                                                </li>
                                                @if($user->sellerProgram)
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold @if(url()->current() ==route('admin.user.survey',[$id,'survey'])) active @endif" href="{{route('admin.user.survey',[$id,'survey'])}}">
                                                        <span class="d-none d-md-block">Survey</span>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="profile-info">
                    <div class="row">
                        @if($view == "info")
                            @include('admin.user.components.tabs.info')
                        @elseif($view == "wallets")
                            @include('admin.user.components.tabs.wallet')
                        @elseif($view == "reviews")
                            @include('admin.user.components.tabs.reviews')
                        @elseif($view == "user-stats")
                            @include('admin.user.components.tabs.stats')
                        @elseif($view == "survey")
                            @include('admin.user.components.tabs.survey')
                        @else
                            @include('admin.user.components.tabs.datatable')
                        @endif
                </section>
            </div>

        </div>
    </div>
</div>
@include('admin.user.components.modal')
@include('admin.user.components.deleted-modal')
@endsection
@push('js')

@if($view != "info" && $view != "wallets" && $view != "user-stats" && $view != "reviews"  && $view != "survey")
@include('admin.components.datatablesScript')
@endif
@if($view == "user-stats")
<script src="{{asset('user/js/jquery.dataTable.min.js')}}"></script>
<script>
    $(document).ready(function () {

        // Datatable Initalized
        var table = $('.datatables').DataTable({
            "sort": false,
            "ordering": false,
            "pagingType": "full_numbers",
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
    })

</script>
@include('admin.components.timepikerScript')
    {{-- account stats data --}}
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

    @if( $user->role != "buyer")
        let doughnutChartEx = $('.doughnut-chart-ex1');
        let barChartEx2 = $('.bar-chart-ex2');


        if (barChartEx2.length) {
            var barChartExample = new Chart(barChartEx2, {
                type: 'bar',
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    responsiveAnimationDuration: 500,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        // Updated default tooltip UI
                        shadowOffsetX: 1,
                        shadowOffsetY: 1,
                        shadowBlur: 8,
                        shadowColor: tooltipShadow,
                        backgroundColor: window.colors.solid.white,
                        titleFontColor: window.colors.solid.black,
                        bodyFontColor: window.colors.solid.black
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true,
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            },
                            scaleLabel: {
                                display: false
                            },
                            ticks: {
                                fontColor: labelColor
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            },
                            ticks: {
                                stepSize: 100,
                                min: 0,
                                fontColor: labelColor
                            }
                        }]
                    }
                },
                data: {
                    labels: @json($earningDates),
                    datasets: [{
                        data: @json($earningData),
                        barThickness: 15,
                        backgroundColor: successColorShade,
                        borderColor: 'transparent'
                    }]
                }
            });
        }
    @endif

    @if($user->role != 'seller')
    {
        let barChartEx1 = $('.bar-chart-ex1');

        if (barChartEx1.length) {
            var barChartExample = new Chart(barChartEx1, {
                type: 'bar',
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    responsiveAnimationDuration: 500,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        // Updated default tooltip UI
                        shadowOffsetX: 1,
                        shadowOffsetY: 1,
                        shadowBlur: 8,
                        shadowColor: tooltipShadow,
                        backgroundColor: window.colors.solid.white,
                        titleFontColor: window.colors.solid.black,
                        bodyFontColor: window.colors.solid.black
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true,
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            },
                            scaleLabel: {
                                display: false
                            },
                            ticks: {
                                fontColor: labelColor
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            },
                            ticks: {
                                stepSize: 100,
                                min: 0,
                                fontColor: labelColor
                            }
                        }]
                    }
                },
                data: {
                    labels: @json($spendingDates),
                    datasets: [{
                        data: @json($spendingData),
                        barThickness: 15,
                        backgroundColor: successColorShade,
                        borderColor: 'transparent'
                    }]
                }
            });
        }
    }
    @endif
</script>

@endif
<script>
    let url = '{{url()->full()}}';
    let url1 = '{{route('admin.user.reviews',[$id,'reviews'])}}';
    let id = '{{$user->id}}';
    let sort = 'high';
    let type = 'seller';
    let revPage = 1;
    $(document).on('change', '.collection_attr', function () {
        
        senRequest()
    })
    $(document).on('change', '.collection_order', function () {
        senRequest()
    })

    function senRequest() {
        url = url.split('?')[0];
        attribute = $('.collection_attr').val();
        order = $('.collection_order').val();
        $.ajax({
            type: "GET",
            data: {
                attribute: attribute,
                order: order,
            },
            url: url,
            success: function (response) {
                $('.append_tabl').html(response.html)
            },
        });
    }

    $(document).on('change', '.sort_review', function () {
        console.log('hello');
        sort = $('.sort_review').val();
        renderReviews();
    })
    $(document).on('change', '.type_review', function () {
        type = $('.type_review').val();
        renderReviews();
    })
 

    $(document).ready(function(){
      renderReviews();
      $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
         url1 =  $(this).attr('href');
         renderReviews();
       })
    })

  function renderReviews()
  {
    $.ajax({
        type: "GET",
        data: {
            type: type,
            sort: sort,
            id:id,
        },
        url: url1,
        success: function (response) {
            $('.render_review').html(response.html)
        },
    });
  }
</script>
@endpush
