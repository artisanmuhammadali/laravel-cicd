<script>
    let endpoint = '{{url()->full()}}';
    let url = '{{url()->full()}}';
    let attribute = '';
    let order = '';
    let language='en';
    let page = 1;
    let limit = 10;
    let user_id = '{{$id}}';
    let blade = '{{$blade}}';
    let set_type = '{{$type}}';
    let tab_type = 'best_price';
    let active = $('.status_active').val();
    let keyword = $('.keyword').val();
    let fill_collect = $('.fill_collect').val();
    let fill_tough = $('.fill_tough').val();
    let fill_cmc = $('.fill_cmc').val();
    let fill_rarity = $('.fill_rarity').val();
    let fill_color = $('.fill_color').val();
    let fill_lang = $('.fill_lang').val();
    let fill_pow_order = $('.fill_pow_order').val();
    let fill_pow = $('.fill_pow').val();
    let fill_char = $('.fill_char').val();
    let fill_condition = $('.fill_condition').val();
    let code = null;
    let card_type = null;
    let rarity = null;
    let form_type = null;

 
    attribute = $('.expansion_attribute').val();
    order = $('.expansion_order').val();

    $(document).on('change', '.tab_head_item', function () {
        tab_type = $(this).data('id');
        senRequest()
    })
    $(document).on('click', '.filter_f', function () {
     active = $('.status_active').val();
     keyword = $('.keyword').val();
     fill_collect = $('.fill_collect').val();
     fill_tough = $('.fill_tough').val();
     fill_cmc = $('.fill_cmc').val();
     fill_rarity = $('.fill_rarity').val();
     fill_color = $('.fill_color').val();
     fill_lang = $('.fill_lang').val();
     fill_pow_order = $('.fill_pow_order').val();
     fill_pow = $('.fill_pow').val();
      fill_condition = $('.fill_condition').val();
      fill_char = $('.fill_char').val();
      code = $(".selectExp").val();
      rarity = $(".selectRarity").val();
      page=1;
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
    $(document).on("click", ".render_vieww", function () {
        active = $('.status_active').val();
     keyword = $('.keyword').val();
     fill_lang = $('.fill_lang').val();
     fill_pow_order = $('.fill_pow_order').val();
     fill_pow = $('.fill_pow').val();
      fill_condition = $('.fill_condition').val();
      fill_char = $('.fill_char').val();
    url = $(this).attr("data-url");
    code = $(".selectExp").val();
    if(!code)
    {
        return false;
    }
    card_type = $(this).attr("data-card");
    rarity = $(".selectRarity").val();
    form_type = $(this).attr("data-type");

    $(".render_view").prop("disabled", true);
    senRequest();
});

    // $(document).ready(function(){
    //    $(document).on('click', '.page-link', function (e) {
    //     e.preventDefault();
    //     $('.page-item').removeClass('active');
    //     $(this).closest('.page-item').addClass('active');
    //     page = $(this).attr('href').split('page=')[1];
    //     senRequest()
    //     });
    // })

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
         let url1 =  $(this).attr('href');
         var urlObject = new URL(url1);
         page = urlObject.searchParams.get('page');
         senRequest();
       })

function senRequest()
{
    $('.sipnner').removeClass('d-none');
    var checkboxValues = [];
    $('.characteristics:checked').each(function(){
            checkboxValues.push($(this).val());
        });
        var foil = $('.item_foil').val();
        attribute = $('.expansion_attribute').val();
        order = $('.expansion_order').val();
        url = url.split('?')[0];
       
        $.ajax({
            type: "GET",
            data: {
                keyword: keyword,
                attribute: attribute,
                order: order,
                tab_type: tab_type,
                user_id: user_id,
                blade: blade,
                foil: foil,
                characters:checkboxValues,
                active :active,
                fill_collect :fill_collect,
                fill_tough :fill_tough,
                fill_cmc :fill_cmc,
                fill_rarity :fill_rarity,
                fill_color :fill_color,
                fill_lang :fill_lang,
                fill_pow_order :fill_pow_order,
                fill_pow :fill_pow,
                fill_condition :fill_condition,
                fill_char :fill_char,
                page :page,
                limit :limit,
                code: code,
                form_type: form_type,
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






</script>
