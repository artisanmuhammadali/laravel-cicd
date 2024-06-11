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
                        <div class="card w-100">
                            <div class="card-header border-bottom ">
                                <h4 class="card-title text-capitalize">Site Visitors</h4>

                            </div>
                            <div class="card-body mt-2">
                                <div>
                                    <div class="toolbar w-100">
                                        <form method="GET" action="{{route('admin.mtg.crm.site.visit')}}">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label> Date</label>
                                                        <input type="text" name="date" id="fp-range"
                                                            class="form-control flatpickr-range  flatpickr-input"
                                                            placeholder="YYYY-MM-DD" readonly="readonly"
                                                            value="{{$date}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <select name="type" class="form-control form-select">
                                                            @foreach(getFilterTypes('time') as $item)
                                                            <option class="">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <button type="submit" class="btn btn-primary ">
                                                        Filter
                                                    </button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th>Area</th>
                                            <th>Visitors</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($visitors as $key => $item)
                                        <tr>
                                            <td>
                                                {{$key}}
                                            </td>
                                            <td>
                                                {{$item->sum('total_visitors')}}
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        <div class="row my-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between">
                        <h4 class="card-title text-capitalize">Site Visitors</h4>
                    </div>
                    <div class="card-body mt-2">
                        <div id="chart" class="w-100">
                            <div class="toolbar w-100">
                                <button id="one_month" class="btn btn-primary">
                                    1M
                                </button>

                                <button id="six_months" class="btn btn-warning">
                                    6M
                                </button>

                                <button id="one_year" class="btn btn-secondary">
                                    1Y
                                </button>

                            </div>

                            <div id="chart-timeline">

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
@include('admin.components.timepikerScript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

<script>
    var oneMonthAgo = new Date();
    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
    var sixMonthAgo = new Date();
    sixMonthAgo.setMonth(sixMonthAgo.getMonth() - 6);
    var oneYearAgo = new Date();
    oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);

    var options = {
        series: [{
            data: @json($data)
        }],
        chart: {
            id: 'area-datetime',
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                autoScaleYaxis: true
            }
        },
        annotations: {

        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
            style: 'hollow',
        },
        xaxis: {
            type: 'datetime',
            min: oneMonthAgo.getTime(),
            tickAmount: 6,
        },
        tooltip: {
            x: {
                format: 'dd MMM yyyy'
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart-timeline"), options);
    chart.render();



    var resetCssClasses = function (activeEl) {
        var els = document.querySelectorAll('button')
        Array.prototype.forEach.call(els, function (el) {
            el.classList.remove('chart_active')
        })

        activeEl.target.classList.add('chart_active')
    }

    document
        .querySelector('#one_month')
        .addEventListener('click', function (e) {
            resetCssClasses(e)

            chart.zoomX(
                oneMonthAgo.getTime(),
                new Date().getTime()
            )
        })

    document
        .querySelector('#six_months')
        .addEventListener('click', function (e) {
            resetCssClasses(e)

            chart.zoomX(
                sixMonthAgo.getTime(),
                new Date().getTime()
            )
        })

    document
        .querySelector('#one_year')
        .addEventListener('click', function (e) {
            resetCssClasses(e)
            chart.zoomX(
                oneYearAgo.getTime(),
                new Date().getTime()
            )
        })



    document.querySelector('#all').addEventListener('click', function (e) {
        resetCssClasses(e)

        chart.zoomX(
            oneYearAgo.getTime(),
            new Date().getTime()
        )
    })

</script>
@endpush
