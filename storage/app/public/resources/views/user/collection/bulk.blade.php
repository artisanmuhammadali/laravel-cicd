@extends('user.layout.app')
@section('title','Characteristics')
@push('css')
<style>
    .dropdown-menuu {
        position: absolute;
        z-index: 1000;
        display: none;
        min-width: 10rem;
        padding: 0.5rem 0;
        margin: 0;
        font-size: 1rem;
        color: #6e6b7b;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(34, 41, 47, 0.05);
        border-radius: 0.357rem;
    }

    .dropdown-menuu.show {
        display: block !important;
    }
</style>
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
                                    <h4 class="card-title mb-50">Bulk Upload</h4>
                                    <div class="alert alert-warning  d-md-none d-flex">
                                        <div class="alert-body">
                                            <p>
                                                <span> <i class="fa-solid fa-circle-info fs-6 me-25"></i></span>
                                                Please click on filter to show data.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-m50p-sm">
                            @include('user.components.collection.filterCollections',['isBulk' => true])
                            </div>
                           
                        </div>
                        @include('user.collection.components.filter')
        
                        <form action="{{route('user.collection.save')}}" id="BulkCollectionForm" method="POST">
                            @csrf
                            <input type="hidden" name="form_type" value="bulk">
                            <input type="hidden" name="mtg_card_type" value="{{request()->type}}">
                            @include('components.spinnerLoader')

                            <div class="card-body GeneralDiv append_cards">
                                
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
</div>
@endsection

@push('js')
@include('user.components.collection.searchScript',['id'=>$auth->id , 'blade'=>'collectionPg'])
<script>
     $(document).on('click', '.toggle_drop_men', function () {
        $(this).closest('div').find('.dropdown-menuu').toggleClass('show');
    })
    $(document).on('click', '.itemm', function () {
        let tex = $(this).text();
        $(this).closest('.mau_div').find('.toggle_drop_men').text(tex);
        $(this).closest('.mau_div').find('.dropdown-menuu').toggleClass('show');
        let sym = $(this).data('val');
        $('.fill_pow_order').val(sym);
    })
    var count;
    $(document).on("submit", "#BulkCollectionForm", function (e) {
        e.preventDefault();
        if (!validate('bulk')) return false;
        if ($("div").hasClass("alert-dangers")) {
            return false;
        }
        $('.form_submit_btn').prop("disabled", true);
        $('.sipnner').removeClass('d-none');
        var formData = {};
        var token;
        $('#BulkCollectionForm :input').each(function() {
            if(this.name == "_token"){
                token = $(this).val();
            }
            formData[this.name] = $(this).val();
        });

        // Convert the collected data into JSON
        var data = JSON.stringify(formData);
        $.ajax({
            type: "POST",
            data:{
                data:data,
                form_type:'bulk',
                card_type:'{{request()->type}}',
                _token:token
            },
            url: $(this).attr("action"),
            success: function(response) {
                $('.form_submit_btn').prop("disabled", false);
                $('.sipnner').addClass('d-none');
                if(response.success){
                    toastr.success(response.success);
                }
                if(response.error){
                    toastr.success(response.error);
                }
                if(response.route)
                {
                    window.location = response.route;
                }
                    window.location = response.modal;
            }
        });
    })
    $(document).on('click','.BulkChar',function() {
        var char = $(this).attr('data-char');
        var input = '.Input'+char;
		if ($(this).is(':checked') == true) {
			$(input).val(1);	
            console.log(input);
			$(input).prop('checked',true);	
		}
		else{
            console.log(input);
			$(input).val(0);	
			$(input).prop('checked',false);
		}
		
	})
    $(document).on('click','.Inputfoil , .Inputsigned , .Inputgraded , .Inputaltered' ,function(){
        if($(this).val() == 1){
            $(this).val(0)
        }
        else{
            $(this).val(1)
        }
    })
    $(document).on('keyup' , '.BulkInputs' ,function() {
        var char = $(this).attr('data-name');
        var input = '.Input'+char;
		var value =$(this).val();
		$(input).val(value);
	})
    $(document).on('change' , '.BulkInputs' ,function() {
        var char = $(this).attr('data-name');
        var input = '.Input'+char;
		var value =$(this).val();
		$(input).val(value);
	})
    $(document).on('change' , '.BulkSelect' ,function() {
		var value =$(this).val();
		$('.InputLanguage').val(value);
	})
    $(document).on('change' , '.BulkCondition' ,function() {
		var value =$(this).val();
		$('.InputCondition').val(value);
	})
    $(document).on('click','.removeBulkItem',function(e){
        updatecardCount(-1)
    var td = e.target.closest('tr');
        $(td).remove();
    })
    function updatecardCount(number)
    {
        var count = parseInt($('.cardCount').text(),10);
        var num = count+number;
     $('.cardCount').text(num);
    }
    $(document).on('click','.cloneBulkItem', function(e) {
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
        clonedInputFields.forEach(function(input, index) {
            clonedInputFields[index].name = clonedInputFields[index].name.replace(/\[\d+\]/g, `[${newIndex}]`);
        });
        clonedSelectFields.forEach(function(input, index) {
            clonedSelectFields[index].name = clonedSelectFields[index].name.replace(/\[\d+\]/g, `[${newIndex}]`);
        });
    
    });
    function getRandomInt(min, max) {
        min = Math.ceil(min);   // Round up the minimum
        max = Math.floor(max);  // Round down the maximum
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>
@endpush
