@extends('admin.layout.app')
@section('title','Dashboard')
@push('css')
<style>
    .remove-icon {
        position: absolute;
        top: -5px;
        right: -5px;
        color: #D84A49;
        cursor: pointer;
    }

</style>
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
                        <div class="card">
                            <div class="card-header">
                                <div class="w-100">
                                    <select name="set_id" id="select2-basic" data-select2-id="select2-basic"
                                        class=" form-select select2-hidden-accessible  atrribute_list select2 w-100">
                                        <option class="form-control" value="">Select Attribute</option>
                                        @foreach($attributes as $att)
                                        <option class="form-control" value="{{$att->id}}" data-name="{{Str::slug($att->name)}}">
                                            {{$att->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div>
                                    <form id="cardForm" method="POST"
                                        action="{{route('admin.mtg.cards.store.products.attributes')}}" class=""
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="append_selected_attributes_inputs"></div>
                                        <div class="row">
                                            <table class="table table-striped table-responsive" id="myTable">
                                                <thead>
                                                    <tr class="head-tr">
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Attributes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cards as $card)
                                                    <tr class="body-tr">
                                                        <input data-lop="{{$loop->iteration}}" type="hidden" name="ids[{{$loop->iteration}}]" value="{{$card->id}}"
                                                            class="ids">
                                                        <th><img src="{{$card->png_image}}" height="50" width="50"></th>
                                                        <td>{{$card->name}}</td>
                                                        <td>
                                                            @foreach($card->attributes as $att)
                                                            <span class="badge bg-primary position-relative"><i
                                                                    data-ref="{{route('admin.mtg.cards.remove.attribute',[$card->id,$att->id])}}"
                                                                    class="remove_att fa fa-trash remove-icon"></i>{{$att->name}}</span>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                  
                                                </tbody>
                                            </table>

                                        </div>
                                        <div>
                                            <button class="btn btn-primary submit scroll-submit" id="addcolumn"
                                                type="submit" style="display: inline-block;">Submit</button>
                                            <input type="button" class="btn btn-primary scroll-submit copy_Save"
                                                name="copy" value="Save As Copy" style="display: inline-block;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marked As Foil ?</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input form="cardForm" type="checkbox" name="is_foil" value="1" class="form-check-input is_foil"
                        id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Copied cards marked as foil only?</label>
                    <input form="cardForm" type="hidden" name="copy" value="copy" class="copyy"
                    id="exampleCheck1">
                </div>
                <div class=" mt-1">
                    <label class="form-check-label" for="exampleCheck1">Choose different expansion for this card </label>
                    <select name="new_set_code" class="form-control new_set_code">
                        <option value="">Select</option>
                        @foreach($sets as $set)
                        <option value="{{$set->code}}">{{$set->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" value="Save As Copy" form="cardForm"
                    class="btn btn-primary is_copy">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).on('click','.is_copy',function(){
        $('.copyy').val('copy');
    })
    $(document).on('click','.submit',function(){
        $('.copyy').val(null);
    })
    $(document).on("submit", "#cardForm", function (e) {
        e.preventDefault();

        if (!validate()) return false;
        if ($("div").hasClass("alert-dangers")) {
            return false;
        }
        // $(".sipnner").removeClass("d-none");
        var form = $(this);
        var data = new FormData(this);
        var object = {};
        data.forEach(function(value, key){
    object[key] = value;
});
object['new_set_code'] = $('.new_set_code').val();
let _token = object._token;
data = JSON.stringify(object);

      
        var submit_btn = $(form).find(".submit_btn");
        $(submit_btn).prop("disabled", true);
     
        $(form).find(".submit_btn").prop("disabled", true);
        $.ajax({
            type: "POST",
            data: {data:data, _token: _token},
            url: $(form).attr("action"),
           
            success: function (response) {
                $(".sipnner").addClass("d-none");
            if (response.success) {
                toastr.success(response.success);
            }
            },
             error: function (xhr, status, error) {
                $(".sipnner").addClass("d-none");
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
                        $(".sipnner").addClass("d-none");
                    }
                });
            } else {
                $(form).find(".submit_btn").prop("disabled", false);
                toastr.error("Unknown Error!");
            }
        },
        });
    });

    $(document).on('click', '.copy_Save', function () {
        $('#copyModal').modal('show');
    })
    $(document).on('click', '.remove_att', function () {
        let url = $(this).data('ref');
        $(this).closest('span').remove();
        $.ajax({
            type: "GET",
            url: url,
        });
    })
    $(document).on('change', '.atrribute_list', function () {
        let namee = $(this).find(':selected').data('name');
        let id = $(this).val();

        if (id && $('.' + namee + '-rows').length <= 0) {
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: '{{route('admin.mtg.cards.append.columns')}}',
                success: function (response) {
                    $('.append_selected_attributes_inputs').append(
                        `<input type="hidden" value="${id}" name="selected_attributes[${id}]" class="selected_atribute_${id}">`
                    )
                    $("#myTable .head-tr").append(
                        `<th class="${namee}-rows">${namee} <i data-type="${namee}" data-att="${id}" class=" cursor-pointer remove-row fa fa-trash text-danger"></i></th>`
                    );
                    $("#myTable .body-tr").append(
                        `<td class="${namee}-columns"> ${response.columns}</td`);

                    $('.' + namee + '-columns').each(function(index){
                        let namee = `attribute[${id}][${index}]`;
                        $(this).find('.attributes_apply').attr('name',namee);
                    })
                },
            });
        }
    })
    $(document).on('click', ".remove-row", function () {
        let namee = $(this).data('type');
        let att = $(this).data('att');
        alert(namee);
        $('.' + namee + '-rows').remove();
        $('.' + namee + '-columns').remove();

        $('.selected_atribute_' + att).remove();
    });

</script>

@endpush
