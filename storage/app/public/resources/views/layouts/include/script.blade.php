<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" > </script>
    @if(count($announcements) > 0)
    <script src="{{ asset('Owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script>
    $('.owl-carousel-annoucement').owlCarousel({
        loop:true,
        margin:0,
        dots:false,
        nav:true,
        items:0,
        slideBy:1,
        autoplay:true,
        autoplayTimeout:10000,
        autoplayHoverPause:true,
        animateOut: 'animate__fadeOut',
        animateIn: 'animate__fadeIn',
        items:1,
        responsive:false,
        autoHeight: true,
        autoWidth:false,
        
    })

    </script>
    
    @endif
    <script>
        var toastrMsg = document.getElementsByClassName('.toastrMsg').value;
        var toastrType = document.getElementsByClassName('.toastrType').value;
        @if(session('success'))
            toastrMsg = "{{ session('success') }}";
            toastrType ='success';
        @elseif(session('error'))
            toastrMsg = "{{ session('error') }}";
            toastrType ='error';
        @elseif(session('status'))
            toastrMsg = "{{ session('status') }}";
            toastrType ='success';
        @endif
    </script>
    <input type="hidden" class="toastrMsg" >
    <input type="hidden" class="toastrType" >
    @vite(['resources/js/app.js', 'resources/js/custom.js'])

    @stack('js')

    <script>
        $(document).ready(function(){
            $.ajax({
                type: "GET",
                url: '{{route('get.visitor.info')}}',
            });
            @if(count($announcements) > 0)
                var announcements_json =  @json($announcements);
                announcements_json.forEach(function(item) {
                    var targetDate = new Date(item.timer).getTime();
                    var x = setInterval(function() {
                        var now = new Date().getTime();            
                        var diff = targetDate - now;
                        
                        $('.announcement_days'+item.id).text(Math.floor(diff / (1000 * 60 * 60 * 24)));
                        $('.announcement_hours'+item.id).text(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                        $('.announcement_minutes'+item.id).text(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)));
                        $('.announcement_seconds'+item.id).text(Math.floor((diff % (1000 * 60)) / 1000));
                    }, 0);
                });
            @endif
        })
        function loadRecaptcha() {
            var script = document.createElement('script');
            script.src = 'https://www.google.com/recaptcha/api.js';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }
    </script>
    <script>
            @if(!cookies('cookies'))
            var cookieAlert = document.querySelector(".cookie-alert");
            var acceptCookies = document.querySelector(".accept-cookies");
            var rejectCookies = document.querySelector(".reject-cookies");

            cookieAlert.offsetHeight;

                cookieAlert.classList.add("show");
            rejectCookies.addEventListener("click", function () {
                cookieAlert.classList.add("hide");
                cookiesAjax("reject",false , false);
            })
            acceptCookies.addEventListener("click", function () {
                var google = $('.google').is(':checked') ? true : false;
                var meta = $('.meta').is(':checked') ? true : false;
                cookiesAjax("accept",google , meta);
            });
            @endif

            function cookiesAjax(permision , google , meta)
            {
                $.ajax({
                    type: "GET",
                    data: {
                        perimsion: permision,
                        google: google,
                        meta:meta
                    },
                    url: '{{route('site.cookies')}}',
                    success: function (response) {
                        $('head').append(response.script);
                    },
                });
                cookieAlert.classList.remove("show");
            }
    </script>