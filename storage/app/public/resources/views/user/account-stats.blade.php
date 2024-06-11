@extends('user.layout.app')
@section('title','Account Stats')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="invoice-preview-wrapper  px-md-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row match-height">
                        @if($auth->role != 'buyer')
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Total Collections</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">{{$collection}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Order Sale</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">{{$order_sale}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Total Earning</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$earning}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Order Purchase</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">{{$order_purchase}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Total Spending</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$spending}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <div class="card">
                                <div class="card-body pb-50" style="position: relative;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>Referral Credit</h6>
                                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$auth->vfs_wallet}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card w-100">
                        <div class="card-body">
                            <div>
                                <div class="toolbar w-100">
                                    <form method="GET" action="{{route('user.account.stats.index')}}">
                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <div class="form-group">
                                                    <label> Date</label>
                                                    <input type="text" name="date" id="fp-range"
                                                        class="form-control flatpickr-range  flatpickr-input"
                                                        placeholder="YYYY-MM-DD" readonly="readonly"
                                                        value="{{$date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-2">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="type" class="form-select text-capitalize ">
                                                        @foreach(getFilterTypes('time') as $item)
                                                        <option class="text-capitalize" value="{{$item}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center mt-2">
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
                @if($auth->role != 'buyer')
                    <div class="col-lg-4 col-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Collections Sale Rate</h4>
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
                                    </div><canvas class="doughnut-chart-ex1 chartjs chartjs-render-monitor"
                                        data-height="275" width="425" height="343"
                                        style="display: block; height: 275px; width: 340px;">
                                    </canvas>
                                </div>
                                <div class="d-flex justify-content-between mt-3 mb-1">
                                    <div class="d-flex align-items-center">
                                        <i data-feather='codesandbox' class="  text-success"></i>
                                        <span class="fw-bolder ms-75 me-50">Total Listed Collections:</span>
                                        <span>{{ $liquidity->total_no }}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <div class="d-flex align-items-center">
                                        <i data-feather='archive' class="  text-primary"></i>
                                        <span class="fw-bolder ms-75 me-50">Not Sold:</span>
                                        <span>{{ $liquidity->pending_no }}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i data-feather='trending-up' class="  text-warning"></i>
                                        <span class="fw-bolder ms-75 me-50">Sold:</span>
                                        <span>{{ $liquidity->convert_no }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12 ">
                        <div class="card">
                            <div
                                class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                <div class="header-left">
                                    <h4 class="card-title">Earnings</h4>
                                </div>
                                <div>
                                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" data-type="earning">Excel</button>
                                    <button class="btn btn-icon btn-outline-danger waves-effect downloadData downloadPdf" data-type="earning">Pdf</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="bar-chart-ex2 chartjs" data-height="400"></canvas>
                            </div>
                        </div>
                    </div>
                @endif
                    <div class="col-lg-8 col-12 ">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                                <div class="header-left">
                                    <h4 class="card-title">Spendings

</h4>
                                </div>
                                <div>
                                    <button class="btn btn-icon btn-outline-success waves-effect downloadData" data-type="spending">Excel</button>
                                    <button class="btn btn-icon btn-outline-danger waves-effect downloadData downloadPdf" data-type="spending">Pdf</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="bar-chart-ex1 chartjs" data-height="400"></canvas>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
</div>
<div class="divDownload d-none"></div>
{{-- data to export --}}
<input type="hidden" value="{{json_encode($earningArray)}}" class="earningArray">
<input type="hidden" value="{{json_encode($spendingArray)}}" class="spendingArray">
@include('user.components.stats.export-to-pdf')
@endsection

@push('js')
{{-- download data in pdf --}}
<script>
    function openPdfModal(type , json)
    {
        var url = '{{route('user.account.stats.export')}}'
        $.ajax({
            type: "GET",
            data: {
                type: type,
                json: json,
            },
            url: url,
            success: function (response) {
                $('.exportDataTable').html(response.html);
                $('.downloadPdfModal').modal('show');
            },
        });

    }
</script>
{{-- download data in excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>
<script>
    $(document).on('click','.downloadData',function(){
        var type = $(this).attr('data-type');
        var json = type == "earning" ? 'earningArray' : 'spendingArray';
        var data = $('.'+json).val();
        if(JSON.parse(data).length == 0)
        {
            return toastr.error('No Record Found.')
        }
        if($(this).hasClass('downloadPdf'))
        {
            openPdfModal(type , data)
        }
        else
        {
            jsonToExcel(data , type)
        }
    })
    function jsonToExcel(jsonData, fileName) {
        const jsonDatasString = jsonData;
        const jsonDatas = JSON.parse(jsonDatasString);
        const worksheet = XLSX.utils.json_to_sheet(jsonDatas);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
        // Generate a file in binary format
        const excelData = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });

        // Convert the binary data to a Blob
        const blob = new Blob([s2ab(excelData)], { type: 'application/octet-stream' });
        // Create a download link and trigger the download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName + '.xlsx';
        document.body.appendChild(a);
        a.click();

        // Clean up
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }
    // Convert string to ArrayBuffer
    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }

</script>
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

    @if( auth()->user()->role != "buyer")
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
                        labels: ['Not Sold', 'Sold'],
                        data: [{{$liquidity->pending_per}}, {{$liquidity->convert_per}}],
                        backgroundColor: [primaryColorShade, warningLightColor],
                        borderWidth: 0,
                        pointStyle: 'rectRounded'
                    }]
                }
            });
        }
    @endif


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
                    labels: @json($dates),
                    datasets: [{
                        data: @json($spendingData),
                        barThickness: 15,
                        backgroundColor: successColorShade,
                        borderColor: 'transparent'
                    }]
                }
            });
        }
</script>
@endpush
