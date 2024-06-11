<script>

    let endpoint = '{{url()->full()}}';
    let url = '{{url()->full()}}';
    let attribute = '';
    let order = '';
    let language='en';
    let page = 1;
    let user_id = '{{$id}}';
    let limit = 10;
    let set_type = '{{$type}}';
    let tab_type = 'best_price';
    let active = $('.status_active').val();
    let keyword = $('.keyword').val();
    let fill_condition = $('.fill_condition').val();
    let fill_language = $('.fill_language').val();
    let fill_char = $('.fill_char').val();
    let fill_pow_order = $('.fill_pow_order').val();
    let fill_pow = $('.fill_pow').val();
    let code = null;
    let card_type = null;
    let rarity = null;
    let form_type = null;

    $(document).on('click','.filter_collections',function(){
        code = $(".selectExp").val();
        rarity = $(".selectRarity").val();
        active = $('.status_active').val();
        keyword = $('.keyword').val();
        fill_condition = $('.fill_condition').val();
        fill_language = $('.fill_language').val();
        fill_char = $('.fill_char').val();
        fill_pow_order = $('.fill_pow_order').val();
        fill_pow = $('.fill_pow').val();
        senRequest()
    })


    $(document).on('change','.show_limit',function(){
        limit = $(this).val();
        senRequest()
    })
    $(document).on('change', '.dynamicPagination', function () {
        page = 1;
        pagination = $('.dynamicPagination').val();
        senRequest()
    })
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
         let url1 =  $(this).attr('href');
         var urlObject = new URL(url1);
         page = urlObject.searchParams.get('page');
         senRequest();
    })

    $(document).on('change','.collection_attributes , .collection_order',function(){
        attribute =  $('.collection_attributes').val();
        order  = $('.collection_order').val();
        senRequest()
    })
    function senRequest()
   {
    $('.sipnner').removeClass('d-none');
    var checkboxValues = [];
    $('.characteristics:checked').each(function(){
            checkboxValues.push($(this).val());
        });
        var foil = $('.item_foil').val();
        url = url.split('?')[0];
       
        $.ajax({
            type: "GET",
            data: {
                keyword: keyword,
                attribute: attribute,
                order: order,
                tab_type: tab_type,
                user_id: user_id,
                active :active,
                fill_lang :fill_language,
                fill_pow_order :fill_pow_order,
                fill_pow :fill_pow,
                fill_condition :fill_condition,
                fill_char :fill_char,
                page :page,
                limit :limit,
                code: code,
                card_type: card_type,
                rarity: rarity,
            },
            url: url,
            success: function (response) {
                $('.append_cards').html(response.html);
                $('.total_active').text(response.active)
                $('.total_inactive').text(response.inactive)
                let total = $('.total_value').val();
                $('.total_collection_count').text(total);
                $('.sipnner').addClass('d-none');

                $(".showOptions").removeClass("d-none");
                $('.filter-card').toggleClass('hide_box');
                $(".form_submit_btn").removeClass("d-none");
            }
        });
}



$(document).on("click", ".submit_collection_formm", function () {
 
 $('.sipnner').removeClass('d-none');
 $(this).closest('.modal').modal('hide');
 let btn = $(this);
 btn.attr("disabled", true);
 let modall = $(this).closest(".modal");
 let link = $(this).data("link");
 let percent = $(".percent").val();
 let operation = $(".operation").val();

 let condition = $('.BulkCondition').val();
 let quantity = $('.bulkQuantity').val();
 let price = $('.bulkPrice').val();
 let language = $('.bulkLangauge').val();
 let foil = $('.bulkFoil').is(':checked') ? 1 : 0;
 let altered = $('.bulkAltered').is(':checked') ? 1 : 0;
 let graded = $('.bulkGraded').is(':checked') ? 1 : 0;
 let signed =  $('.bulkSigned').is(':checked') ? 1 : 0;
 
 let form_type = $(this).data("form");
 let publish = $(this).data("publish");

 $.ajax({
     type: "GET",
     data: {

         condition: condition,
         quantity: quantity,
         price: price,
         language: language,
         foil: foil,
         signed: signed,
         altered: altered,
         graded: graded,

         keyword:keyword,
         form_type: form_type,
         publish: publish,
         percent: percent,
         operation: operation,
         ids: ids,
         is_all: is_all,
         set_type: set_type,
         fill_lang: fill_language,
         fill_pow_order: fill_pow_order,
         fill_pow: fill_pow,
         fill_condition: fill_condition,
         fill_char: fill_char,
         code: code,
         rarity: rarity,
         active :active,
     },
     url: link,
     
     success: function (response) {

         if(response.route)
         {
             window.location.href = response.route;
         }
         else{
             btn.attr("disabled", false);
             if (response.error) {
                 toastr.error(response.error);
                 $('.sipnner').addClass('d-none');
                 return false;
             }
             modall.modal("hide");
             $(".collectionActionDiv")
                 .removeClass("d-block d-lg-flex")
                 .addClass("d-none");
             toastr.success(response.success);
             senRequest();
         }
         
         // senRequest();
     },
 });
});
</script>