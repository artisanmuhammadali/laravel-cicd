@extends('admin.layout.app')
@section('title','Bulk Upload')
@push('css')
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
        <div class="content-body">
            <section class="app-user-view-app-user-view-account d-flex justify-content-center">
                <div class="row w-100" id="table-hover-row">
                    <div class="col-12">
                        <div class="card p-5">
                            <form action="{{route('admin.mtg.products.store')}}" class="csvForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="form_type" class="form_type" value="csv">
                                <input type="hidden" name="check" value="1" class="form_check">
                                <input type="hidden" name="mtg_card_type" value="{{request()->type ?? ""}}">
                                <div class="d-flex justify-content-center">
                                    <div class="sipnner d-none position-absolute" style="top: 200px;">
                                        <div class="spinner-grow text-secondary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-secondary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-secondary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-secondary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    {{-- <div class="col-md-12">Download {{$type}} Uploading Template</div> --}}
                                    <div class="col-md-8">
                                        <label class="form-label" for="modalAddressCountry">EXCEL/CSV upload</label>
                                        <input type="file" name="data" accept=".csv, .xlsx" id="csvFileInput" class="csvUpload form-control w-75">
                                        {{-- <button class="btn btn-primary mt-2">Upload</button> --}}
                                    </div>
                                    <div class="col-md-4">
                                        <p class="my-auto">
                                            @php($filename="csvFormats/upload-".$type."-products.xlsx")
                                            <a href="{{asset($filename)}}" download> Click here</a>
                                            to Download Uploading Template.
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
</div>
<input type="hidden" value="{{$type}}" class="mtg_card_type">
@endsection
@push('js')
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
        var xl2json = new ExcelToJSON();
        var rows = xl2json.parseExcel(files[0] , 'header');
    })
    function getExcelHeader(rows)
    {
        // console.log(rows);
        var firstRow = rows[0];
        var url = "{{route('admin.mtg.products.render.views')}}";
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

                if(response.redirect)
                {
                    window.location = "{{route('admin.mtg.products.index')}}/"+card_type;
                }
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


