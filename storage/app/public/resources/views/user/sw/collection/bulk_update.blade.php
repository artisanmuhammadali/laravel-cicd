@extends('user.layout.app')
@section('title','Characteristics')
@push('css')
@endpush
@section('content')
<div class="content-wrapper container-xxl pt-0 px-0 pb-sm-0 pb-5">
    <div class="content-body">
        <section class="app-user-app-user-view-account d-flex justify-content-center-account justify-content-center ">
            <div class="row w-100" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-start d-flex justify-content-center">
                            <div class="row  w-100 py-2">
                                <div class="col-12 text-start">
                                    <h4 class="card-title mb-50">Bulk Update</h4>
                                </div>
                            </div>
                            <form class="w-100" action="{{route('user.collection.bulk.edit.save')}}" id="BulkCollectionForm"
                                method="POST">
                                @csrf
                                <input type="hidden" name="mtg_card_type" value="{{$tab_type}}">
                                @include('components.spinnerLoader')

                                <div class="card-body GeneralDiv px-0">
                                    <div class="row w-100  mb-3 showOptions">
                                        <div class="col-md-3 col-6">
                                            <label for="language">Language</label>
                                            <select class="form-select BulkSelect" name="language">
                                                <option selected disabled id="language">Select Language</option>
                                                @foreach(getLanguages() as $key => $lang)
                                                <option class="form-control" value="{{$key}}">{{$lang}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 col-sm-4 col-6">
                                            <label for="quantity">Quantity</label>
                                            <input class="form-control BulkInputs" name="quantity" data-name="quantity" placeholder="1"
                                                min="1" type="number" id="quantity" placeholder="1">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6">
                                            <label for="price">Price</label>
                                            <input class="form-control BulkInputs" name="price" data-name="price" step="0.01"
                                                min="0.01" type="number" id="price" placeholder="1">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6">
                                            <label for="price">Condition</label>
                                            <select class="form-select BulkCondition" name="condition">
                                                <option class="form-control" value="NM">NM</option>
                                                <option class="form-control" value="LP">LP</option>
                                                <option class="form-control" value="MP">MP</option>
                                                <option class="form-control" value="HP">HP</option>
                                                <option class="form-control" value="DMG">Dmg</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <label for="note">Note</label>
                                            <input class="form-control BulkInputs" name="note" data-name="note" type="text"
                                                id="note">
                                        </div>
                                        <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-info mt-2">
                                            <input type="checkbox" class="form-check-input BulkChar" name="foil" data-char="foil"
                                                data-name="foil" id="foilCheck">
                                            <label class="form-check-label" for="foilCheck">Foil</label>
                                        </div>
                                        <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-secondary mt-2 ">
                                            <input type="checkbox" class="form-check-input BulkChar" name="altered" data-char="altered"
                                                data-name="altered" id="alteredCheck">
                                            <label class="form-check-label" for="alteredCheck">Altered</label>
                                        </div>
                                        <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-success mt-2">
                                            <input type="checkbox" class="form-check-input BulkChar" name="graded" data-char="graded"
                                                data-name="graded" id="gradedCheck">
                                            <label class="form-check-label" for="gradedCheck">Graded</label>
                                        </div>
                                        <div class="ps-3 col-sm-3 col-6 form-check my-auto form-check-warning mt-2">
                                            <input type="checkbox" class="form-check-input BulkChar" name="signed" data-char="signed"
                                                data-name="signed" id="signedCheck">
                                            <label class="form-check-label" for="signedCheck">Signed</label>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row justify-content-between">
                                        <div class="col-12  px-2 py-1 d-flex justify-content-between align-items-center">
                                            <p class="fw-6 mb-0"><span
                                                    class="fw-bold text-black cardCount">{{count($list)}}</span> Results
                                                Found</p>
                                            @if(count($list) > 0)
                                            <button class="btn btn-primary publishBtn form_submit_btn"
                                                type="submit">Update collection</button>
                                            @endif
                                        </div>
                                    </div>
                                    @if(count($list) < 1)
                                    <div class="row text-center">
                                        <div class="text-danger text-center">
                                            No Record Found
                                        </div>
                                    </div>
                                    @else
                                    <div class="table-responsive" style="height: 600px">
                                        <table class="table table-hover">
                                            <thead class="tabl-header">
                                                <tr>
                                                    <th>Actions</th>
                                                    <th>Icon</th>
                                                    <th>Card</th>
                                                    <th>Set</th>
                                                    <th>Condition</th>
                                                    <th>Language</th>
                                                    <th>Characteristics</th>
                                                    <th>Qty</th>
                                                    <th class="text-truncate">Price</th>
                                                    <th class="text-truncate">Card Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list as $lit)
                                                @php($item = $lit->card)
                                                <tr class="itemRow{{$item->id}}">
                                                    <td class="py-0 px-25">
                                                        <div class="d-flex justify-content-around">
                                                            <button type="button"
                                                                class="btn btn-icon btn-outline-danger waves-effect  removeBulkItem w-25 py-25 h-50 px-0"
                                                                data-id="{{$lit->id}}">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-icon btn-outline-primary waves-effect  editBulkItem w-25 py-25 h-50 px-0" data-url="{{route('user.collection.edit',$lit->id)}}" title="Edit"
                                                                data-id="{{$lit->id}}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-image myDIV h4Btn me-1"></i>
                                                                {{--<!-- <img class="myDIV h4Btn me-1" src="{{$item->png_image}}" width="50px" alt="{{$item->name}}" loading="lazy"> -->--}}
                                                                <div class="hide hand h4 " style="left: 32rem; top: 0px !important;">
                                                                    <img  class="rounded-3" alt="very friendly shark" width="250" src="{{$item->png_image}}" alt="{{$item->name}}" loading="lazy"/>
                                                                </div>
                                                        </td>
                                                        <td class=" align-items-center ">
                                                            @if($item)
                                                              <a href="{{route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])}}" target="_blank" class="fw-bold fs-12p-sm">{{$item->name}}</a>
                                                             @endif
                                                        </td>
                                                        <td>
                                                            @if($item)
                                                            <img loading="lazy" src="{{$item->set->icon  ?? ""}}" style="filter: url({{"#".$item->rarity."_rarity"}});" class="me-75" height="40" width="40" alt="Angular" title="{{$item->set->name}}">
                                                            @endif
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <select
                                                                class="form-select required InputCondition bulk-options bulk-options-font">
                                                                @foreach(getConditions() as $key => $c)
                                                                @php($selected = $lit->condition == $key ? 'selected' : '')
                                                                <option {{$selected}} class="form-control" value="{{$key}}">
                                                                    {{$c}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <select
                                                                class="form-select InputLanguage required bulk-options bulk-options-font">
                                                                @foreach(getLanguages() as $key => $lang)
                                                                @php($selected = $lit->language == $key ? 'selected' : '')
                                                                <option {{$selected}} class="form-control" value="{{$key}}">
                                                                    {{$lang}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <div class="form-check my-auto form-check-info">
                                                                @php($checked = $lit->foil == 1 ? 'checked' : '')
                                                                <input type="checkbox" value="{{$lit->foil}}" {{$checked}}
                                                                    class="form-check-input foiled  {{$item->foil == 0 && $item->card_type == "single" ? "" : "Inputfoil"}} "
                                                                    {{$item->foil == 0 && $item->card_type == "single"  ? "disabled" : ""}}
                                                                    id="foilCheck{{$loop->iteration+1}}">
                                                                <label class="form-check-label bulk-options-font"
                                                                    for="foilCheck{{$loop->iteration+1}}">Foil</label>
                                                            </div>
                                                            <div class="form-check my-auto form-check-secondary">
                                                                @php($checked = $lit->altered == 1 ? 'checked' : '')
                                                                <input type="checkbox" value="{{$lit->altered}}" {{$checked}}
                                                                    class="form-check-input Inputaltered"
                                                                    id="alteredCheck{{$loop->iteration+1}}">
                                                                <label class="form-check-label bulk-options-font"
                                                                    for="alteredCheck{{$loop->iteration+1}}">Altered</label>
                                                            </div>
                                                            <div class="form-check my-auto form-check-success">
                                                                @php($checked = $lit->graded == 1 ? 'checked' : '')
                                                                <input type="checkbox" value="{{$lit->graded}}" {{$checked}}
                                                                    class="form-check-input Inputgraded"
                                                                    id="gradedCheck{{$loop->iteration+1}}">
                                                                <label class="form-check-label bulk-options-font"
                                                                    for="gradedCheck{{$loop->iteration+1}}">Graded</label>
                                                            </div>
                                                            <div class="form-check my-auto form-check-warning">
                                                                @php($checked = $lit->signed == 1 ? 'checked' : '')
                                                                <input type="checkbox" value="{{$lit->signed}}" {{$checked}}
                                                                    class="form-check-input Inputsigned"
                                                                    id="signedCheck{{$loop->iteration+1}}">
                                                                <label class="form-check-label bulk-options-font"
                                                                    for="signedCheck{{$loop->iteration+1}}">Signed</label>
                                                            </div>
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <input type="number"
                                                                class="form-control Inputquantity required m-auto bulk-options-font"
                                                                min="1" 
                                                                value="{{$lit->quantity}}" placeholder="1">
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <input type="number"
                                                                class="form-control Inputprice required m-auto bulk-options-font"
                                                                value="{{$lit->price}}" step="0.01" min="0.01" placeholder="1">
                                                        </td>
                                                        <td class="py-0 px-25">
                                                            <input type="text" value="{{$lit->note}}"
                                                                class="form-control Inputnote w-75 m-auto bulk-options-font">
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                                <hr>
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
<script>
    
    var count;
    var ids_ar = '{{$ids}}';
    let idss = ids_ar.split(', ');
   
    $(document).on('click','.editBulkItem',function(){
        let id = $(this).data('id');
        alert(id);
        let tr = $(this).closest('tr');
        let language = tr.find('.InputLanguage').val();
        let condition = tr.find('.InputCondition').val();
        let price = tr.find('.Inputprice').val();
        let note = tr.find('.Inputnote').val();
        let quantity = tr.find('.Inputquantity').val();
        let foil = tr.find('.foiled').val();
        let altered = tr.find('.Inputaltered').val();
        let graded = tr.find('.Inputgraded').val();
        let signed = tr.find('.Inputsigned').val();

        $.ajax({
        type: "GET",
        data: {
            form_type:'modal',
            language:language,
            condition:condition,
            price:price,
            note:note,
            quantity:quantity,
            foil:foil,
            altered:altered,
            graded:graded,
            signed:signed,
            id:id,
            is_bulk:'bulk',
        },
        url: '{{route('user.collection.save')}}',
        success: function (response) {
            toastr.success(response.success);
            id = id.toString();
            var index = idss.indexOf(id);
             if (index !== -1) {
               idss.splice(index, 1);
             } 

             console.log(idss);
        }
        });
        
    })
    $(document).on("submit", "#BulkCollectionForm", function (e) {
        e.preventDefault();
        if (!validate('bulk')) return false;
        if ($("div").hasClass("alert-dangers")) {
            return false;
        }
        $('.form_submit_btn').prop("disabled", true);
        $('.sipnner').removeClass('d-none');
        var form = $(this);
        var commaSeparatedString = idss.join(', ');
        var data = new FormData(this);
        data.append('idss', commaSeparatedString);
        // Convert the collected data into JSON
        console.log(data);
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
                toastr.success(response.success);
                window.location.href = response.route;
            }
        });
    })

    $(document).on('click', '.Inputfoil , .Inputsigned , .Inputgraded , .Inputaltered', function () {
        if ($(this).val() == 1) {
            $(this).val(0)
        } else {
            $(this).val(1)
        }
    })
   
 
 
 
    $(document).on('click', '.removeBulkItem', function (e) {
        let id = $(this).data('id');
        id = id.toString();
        console.log(id);
        var index = idss.indexOf(id);
        if (index !== -1) {
          idss.splice(index, 1);
        } 
        
        console.log(idss);
        updatecardCount(-1)
        var td = e.target.closest('tr');
        $(td).remove();
    })

    function updatecardCount(number) {
        var count = parseInt($('.cardCount').text(), 10);
        var num = count + number;
        $('.cardCount').text(num);
    }
    $(document).on('click', '.cloneBulkItem', function (e) {
        updatecardCount(+1)
        // Get the row containing the clicked button
        const clickedRow = e.target.closest('tr');
        // Clone the clicked row
        const clonedRow = clickedRow.cloneNode(true);
        // Insert the cloned row right after the clicked row
        clickedRow.parentNode.insertBefore(clonedRow, clickedRow.nextSibling);

        const newIndex = getRandomInt(1500, 100000);
        // clonedRow.addClass('bg-primary')
        const clonedInputFields = clonedRow.querySelectorAll('input');
        const clonedSelectFields = clonedRow.querySelectorAll('select');
        clonedInputFields.forEach(function (input, index) {
            clonedInputFields[index].name = clonedInputFields[index].name.replace(/\[\d+\]/g,
                `[${newIndex}]`);
        });
        clonedSelectFields.forEach(function (input, index) {
            clonedSelectFields[index].name = clonedSelectFields[index].name.replace(/\[\d+\]/g,
                `[${newIndex}]`);
        });

    });

    function getRandomInt(min, max) {
        min = Math.ceil(min); // Round up the minimum
        max = Math.floor(max); // Round down the maximum
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

</script>
@endpush
