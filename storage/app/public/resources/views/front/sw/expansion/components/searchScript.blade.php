<script>
    let searchType = '{{$searchType }}';
    let endpoint = '{{url()->full()}}';
    let url = '{{url()->full()}}';
    let type = '{{$type ?? ""}}';
    let item = '{{request()->item}}';
    let keyword = '';
    let attribute = '';
    let order = '';
    let page = 1;
    let tab_type = 'best_price';
    let pagination = 9;
    $(document).on('keyup', '.keyword', function () {
        keyword = $('.keyword').val();
        if(keyword.length >= 3 || keyword.length == 0)
        {
            senRequest()
        }
        else{
            return false;
        }
        
    })
    $(document).on('change', '.expansion_attribute', function () {
        senRequest()
    })
    $(document).on('change', '.dynamicPagination', function () {
        page = 1;
        senRequest()
    })
    $(document).on('change', '.expansion_order', function () {
        senRequest()
    })
    $(document).on('click', '.tab_head_item', function () {
        tab_type = $(this).data('id');
        senRequest()
    })

    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: '{{route('cart.empty.cart.after.day')}}',
        });
       $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        $('.page-item').removeClass('active');
        $(this).closest('.page-item').addClass('active');
        page = $(this).attr('href').split('page=')[1];
        senRequest()
        $('html, body').animate({
                scrollTop: $(".filter-section").offset().top
            }, 100);
        });

    })

function senRequest()
{
        url = searchType == 'detailed' ? url : url.split('?')[0];
        url = url.replace(/amp;/g, '');
        keyword = $('.keyword').val();
        attribute = $('.expansion_attribute').val();
        order = $('.expansion_order').val();
        pagination = $('.dynamicPagination').val();
        $.ajax({
            type: "GET",
            data: {
                keyword: keyword,
                attribute: attribute,
                order: order,
                tab_type: tab_type,
                item:item,
                type:type,
                pagination: pagination,
                page:page
            },
            url: url,
            success: function (response) {
                $('.append_cards').html(response.html)
            },
        });
}
</script>