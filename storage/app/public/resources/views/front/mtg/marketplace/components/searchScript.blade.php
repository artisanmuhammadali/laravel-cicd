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
    let set_name = $('.set_name').val();
    let exact_set_name = $('.exact_set_name').val();
    let code = null;
    let card_type = null;
    let rarity = null;
    let form_type = null;
    let pagination = 50;

 
    attribute = $('.expansion_attribute').val();
    order = $('.expansion_order').val();

    $(document).on('change', '.tab_head_item', function () {
        tab_type = $(this).data('id');
        senRequest()
    })
    $(document).on('click', '.tab_head_item_front', function () {
        tab_type = $(this).data('id');
        pagination = $('.dynamicPagination').val();
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
    $(document).on('submit','.marketplace-filter',function(e){
        $('.sipnner').removeClass('d-none');
    })
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
         let url1 =  $(this).attr('href');
         var urlObject = new URL(url1);
         page = urlObject.searchParams.get('page');
         senRequest();
         $('html, body').animate({
                scrollTop: $(".filter-section").offset().top
            }, 100);
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
		url = url.replaceAll("amp;","");
        url = url;
       
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
                set_name: set_name,
                exact_set_name: exact_set_name,
                rarity: rarity,
                pagination: pagination,
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
