@extends('user.layout.app')
@section('title','CSV Upload')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/dashboard/css/dataTables.bootstrap4.min.css') }}" />
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-view-app-user-view-account d-flex justify-content-center">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12">
                    <div class="card p-3">
                        <div class="row mb-2">
                            <table class="table table-hover datatables d-none">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Total Items Found</th>
                                        <th>Items Upload to Collection</th>
                                        <th>Items Failed to match</th>
                                        <th>Upload on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                    <tr>
                                        <td>
                                            <a href="{{$item->file}}" download target="_blank">{{$item->name}}</a>
                                        </td>
                                        <td>
                                            <span class="badge w-100 text-center {{csvStatusBadges($item->status)}} text-capitalize">{{$item->status}}</span>
                                        </td>
                                        <td>{{$item->total}}</td>
                                        <td>
                                            {{$item->success}}
                                            @if($item->success > 0 && $item->status != "processing")
                                            <a download="{{$item->success_file}}"  href="{{asset('storage/'.$item->success_file)}}">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->total - $item->success}}
                                            @if(($item->total - $item->success) > 0  && $item->status != "processing")
                                            <a download="{{$item->wrong_file}}"  href="{{asset('storage/'.$item->wrong_file)}}">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{$item->created_at->format('Y/m/d')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form action="{{route('user.collection.save')}}" class="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_type" class="form_type" value="csv">
                            <input type="hidden" name="check" value="1" class="form_check">
                            <input type="hidden" name="mtg_card_type" value="{{request()->type ?? ""}}">
                            @include('components.spinnerLoader')
                            <div class="d-md-flex">
                                <div class="col-md-6">
                                    @if($pending == 0)
                                    <label class="form-label" for="modalAddressCountry">CSV upload</label>
                                    <input type="file" name="data" accept=".csv, .xlsx" id="csvFileInput" class="csvUpload form-control  w-75">
                                    @else
                                    <div class="alert alert-warning rounded-0 me-2" role="alert">
                                        <div class="alert-body d-md-flex d-block justify-content-between align-items-center">
                                            <p><span class=" fw-bolder"><i class="fa-solid fa-circle-info fs-6 me-25"></i></span>
                                                Note: You can upload another collection file once your currently pending/processing file has been completed.
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p class="mt-25">
                                        @php($filename="bulk-format-".$type.".xlsx")
                                        <a href="{{asset('csvFormats/'.$filename)}}" download> Click here</a>
                                        to download correct format.
                                    </p>
                                    <p class="mb-5 mt-25">
                                        <a href="{{asset('csvFormats/expansion_list.xlsx')}}" download> Click here</a>
                                        to download List of all Expansion Name from our record.
                                    </p>
                                </div>
                            </div>
                            <div class="appendHeaderHeader"></div>
                            <div class="appendHeaderBox"></div>

                        </form>

                    </div>
                </div>
                
            </div>
        </section>
    </div>
</div>
<input type="hidden" value="{{$type}}" class="mtg_card_type">
@endsection
@push('js')
<script src="{{asset('user/js/jquery.dataTable.min.js')}}"></script>
<script>
    $(document).ready(function(){
        // Datatable Initalized
        $('.sipnner').removeClass('d-none');
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
        setTimeout(function () {
            $('.sipnner').addClass('d-none');
            $('.datatables').removeClass('d-none');
        }, 300);
    })
</script>
<script src="{{asset('admin/vendors/js/editors/quill/quill.min.js')}}"></script>
<script src="{{asset('admin/js/scripts/pages/page-blog-edit.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.1/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.1/xlsx.js"></script>
<script>
    var csvData;
    var ExcelToJSON = function () {
        this.parseExcel = function (file , type) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var data = e.target.result;
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });
                var textToPrint = "";
                workbook.SheetNames.forEach(function (sheetName) {
                    var XL_row_object = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName],{
                        header:'A'
                    });
                    csvData = XL_row_object;
                    getExcelHeader(csvData)

                });
            };
            reader.onerror = function (ex) {
                console.log(ex);
            };
            reader.readAsBinaryString(file);
        };
    };
    $(document).on('change', '.csvUpload', function (evt) {
        var files = evt.target.files; // FileList object
        const fileName = files[0].name;
        const fileExtension = fileName.split('.').pop().toLowerCase();
        if(fileExtension == "csv" || fileExtension == "xlsx")
        {
            var xl2json = new ExcelToJSON();
            var rows = xl2json.parseExcel(files[0] , 'header');
        }
        else{
            toastr.error('Please Select CSV/EXCEL File.')
        }
    })
    function getExcelHeader(rows)
    {
        // console.log(rows);
        var firstRow = rows[0];
        var url = "{{route('user.collection.renderViews')}}";
        var type = $('.mtg_card_type').val();
        $.ajax({
            type: "GET",
            data:{
                form_type:'csvOptions',
                mtg_card_type:type,
                headRow:firstRow,
            },
            url: url,
            success: function(response) {
                $('.appendHeaderHeader').empty();
                $('.appendHeaderHeader').removeClass('d-none');
                $('.appendHeaderHeader').html(response.html);
            }
        });
    }
    $(document).on("submit", ".csvForm", function (e) {
        e.preventDefault();
        if (!validate()) return false;
        if ($("div").hasClass("alert-dangers")) {
            return false;
        }
        var form_type = $('.form_type').val();
        if(form_type == "csv"){
            toastr.info("Please wait your request has sent.");
            $('.sipnner').removeClass('d-none');
        }
        $('.appendHeaderHeader').addClass('d-none');
        // return false;
        var form = $(this);
        var submit_btn = $(form).find(".submit_btn");
        $(submit_btn).prop("disabled", true);
        $(submit_btn).closest("div").find(".loader").removeClass("d-none");
        // console.log(from);
        var formData = JSON.stringify(csvData);
        var card_type = $('.mtg_card_type').val();
        var data = new FormData(this);
        data.append('csv',formData)
        data.append('mtg_card_type',card_type)
        data.append('form_type','csv')
        if($('.checked').val()){
            data.append('check',0);
        }
        $(form).find(".submit_btn").prop("disabled", true);
        $.ajax({
            type: "POST",
            data: data,
            cache: !1,
            contentType: !1,
            processData: !1,
            url: $(form).attr("action"),
            async: true,
            headers: {
                "cache-control": "no-cache",
            },
            success: function (response) {
                $('.sipnner').addClass('d-none');
                $('.appendHeaderBox').empty();
                $('.appendHeaderBox').html(response.response);
                // console.log(response.response)
            },
            error: function (xhr, status, error) {
                $(submit_btn).prop("disabled", false);
                $(submit_btn).closest("div").find(".loader").addClass("d-none");
                if (xhr.status == 422) {
                    $(form).find("div.alert").remove();
                    var errorObj = xhr.responseJSON.errors;
                    $.map(errorObj, function (value, index) {
                        var appendIn = $(form)
                            .find('[name="' + index + '"]')
                            .closest("div");
                        if (!appendIn.length) {
                            toastr.error(value[0]);
                        } else {
                            $(appendIn).append(
                                '<div class="alert alert-danger" style="padding: 1px 5px;font-size: 12px"> ' +
                                value[0] +
                                "</div>"
                            );
                        }
                    });
                    $(form).find(".submit_btn").prop("disabled", false);
                } else {
                    $(form).find(".submit_btn").prop("disabled", false);
                    toastr.error("Unknown Error!");
                }
            },
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>

<script>
    $(document).on('click','.showError',function(){
        $('.errorData').removeClass('d-none')
    })
    $(document).on('click','.downloadError',function(){
        var data = $('.csvErrorsData').val();
        // console.log(data);
        data =JSON.parse(data);
        console.log(data);
        
        jsonToExcel(data , 'errors')
    })
    function jsonToExcel(jsonData, fileName) {
    const worksheet = XLSX.utils.json_to_sheet(jsonData);
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
@endpush


