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
                                        <form method="GET" action="{{route('admin.mtg.crm.collection.listing')}}">
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
                                <h4 class="card-title text-capitalize"> Users Collections</h4>
                            </div>
                            <div class="card-body mt-2">

                                <div class="table-responsive">
                                    <table class="table table-hover datatables">
                                        <thead>
                                            <tr>
                                                <th>Area</th>
                                                <th>Visitor</th>
                                                <th>Registered users</th>
                                                <th>ratio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ratios as $item)
                                            <tr>
                                                <td>
                                                    {{$item['key']}}
                                                </td>
                                                
                                                <td>
                                                    {{$item['visitors']}} 
                                                </td>
                                                <td>
                                                    {{$item['users']}}
                                                </td>
                                                <td>
                                                    {{$item['ratio']}} %
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                                <canvas class="line-chart-ex1 chartjs"></canvas>
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
    let lineChartEx1 = $('.line-chart-ex1');
    if (lineChartEx1.length) {
    var lineExample = new Chart(lineChartEx1, {
      type: 'line',
      plugins: [
        // to add spacing between legends and chart
        {
          beforeInit: function (chart) {
            chart.legend.afterFit = function () {
              this.height += 20;
            };
          }
        }
      ],
      options: {
        responsive: true,
        maintainAspectRatio: false,
        backgroundColor: false,
        hover: {
          mode: 'label'
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
        layout: {
          padding: {
            top: -15,
            bottom: -25,
            left: -15
          }
        },
        scales: {
          xAxes: [
            {
              display: true,
              scaleLabel: {
                display: true
              },
              gridLines: {
                display: true,
                color: grid_line_color,
                zeroLineColor: grid_line_color
              },
              ticks: {
                fontColor: labelColor
              }
            }
          ],
          yAxes: [
            {
              display: true,
              scaleLabel: {
                display: true
              },
              ticks: {
                stepSize: 100,
                min: 0,
                fontColor: labelColor
              },
              gridLines: {
                display: true,
                color: grid_line_color,
                zeroLineColor: grid_line_color
              }
            }
          ]
        },
        legend: {
          position: 'top',
          align: 'start',
          labels: {
            usePointStyle: true,
            padding: 25,
            boxWidth: 9
          }
        }
      },
      data: {
        labels: @json($dates),
        datasets: [
          {
            data: @json($visitorData),
            label: 'Visitors',
            borderColor: lineChartDanger,
            lineTension: 0.5,
            pointStyle: 'circle',
            backgroundColor: lineChartDanger,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBorderColor: window.colors.solid.white,
            pointHoverBackgroundColor: lineChartDanger,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: tooltipShadow
          },
          {
            data: @json($userData),
            label: 'Registered Users',
            borderColor: lineChartPrimary,
            lineTension: 0.5,
            pointStyle: 'circle',
            backgroundColor: lineChartPrimary,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBorderColor: window.colors.solid.white,
            pointHoverBackgroundColor: lineChartPrimary,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: tooltipShadow
          },
          {
            data: @json($percentage),
            label: 'Ratio',
            borderColor: warningColorShade,
            lineTension: 0.5,
            pointStyle: 'circle',
            backgroundColor: warningColorShade,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBorderColor: window.colors.solid.white,
            pointHoverBackgroundColor: warningColorShade,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: tooltipShadow
          }
        ]
      }
    });
  }
</script>
@endpush
