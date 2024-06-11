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
                            <div class="card-body">
                                <div>
                                    <div class="toolbar w-100">
                                        <form method="GET" action="{{route('admin.mtg.crm.success.checkout')}}">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row same_height_row">
                    <div class="col-md-6">
                        <div class="card w-100">
                            <div class="card-header border-bottom ">
                                <h4 class="card-title text-capitalize">Success Checkouts</h4>
                                <div>
                                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" title="Export in Excel" data-type="success-checkout">
                                        <i data-feather='file-text'></i>
                                    </button>
                                    <button class="btn btn-icon btn-outline-danger waves-effect downloadData downloadPdf" title="Export in PDF" data-type="success-checkout">
                                        <i data-feather='printer'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body mt-2">

                                <div class="table-responsive">
                                    <table class="table table-hover datatables">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Checkouts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key}}
                                                </td>
                                                <td>
                                                    {{$item->sum('total_checkouts')}}
                                                </td>

                                            </tr>
                                            <?php
                                                $SuccessCheckout[$loop->iteration]['Area'] = $key;
                                                $SuccessCheckout[$loop->iteration]['Checkouts'] = $item->sum('total_checkouts');
                                            ?>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <input type="hidden" value="{{json_encode($SuccessCheckout)}}" id="success-checkout"> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card w-100">
                            <div
                                class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                <div class="header-left">
                                    <h4 class="card-title"></h4>
                                </div>
                            </div>
                            <div class="card-body my-2">
                                <canvas class="bar-chart-ex5 chartjs"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@include('admin.components.export.pdf-preview-modal')

@endsection

@push('js')
@include('admin.components.export-pdf-excel')
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
<script src="{{asset('admin/vendors/js/charts/chart.min.js')}}"></script>
<script src="{{asset('admin/js/scripts/charts/chart-chartjs.js')}}"></script>

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
    let barChartEx5 = $('.bar-chart-ex5');

        if (barChartEx5.length) {
            var barChartExample = new Chart(barChartEx5, {
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
                                max: 400,
                                fontColor: labelColor
                            }
                        }]
                    }
                },
                data: {
                    labels: @json($dates),
                    datasets: [{
                        data: @json($data),
                        barThickness: 15,
                        backgroundColor: successColorShade,
                        borderColor: 'transparent'
                    }]
                }
            });
        }

</script>
@endpush
