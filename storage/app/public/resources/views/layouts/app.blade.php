<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.include.common_cookies')
    @include('layouts.include.head')
    
</head>

<body class="font-sans antialiased">
        @if(cookies('google-cookies')  == "true")
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZ598XB9"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        @endif
        @include('front.components.announcement.carousel')
        @include('front.include.nav')
        @include('front.components.mtgSet.rarity-icon')


            @yield('content')
            @include('front.include.bottom-nav')
            @if(!Route::is('cart.index') && !Route::is('checkout.confirm'))
            <footer class="footer_section d-md-block d-none">
                <div class="container">
                    @include('front.include.footer')
                </div>
            </footer>
            @endif
            
            @include('front.components.loader')
            @include('front.modals.login')
            @include('front.modals.register')
            @include('front.modals.registration-options')
            @include('front.modals.setting_canvas')
            @include('front.modals.expPageFilter')
            @if(!cookies('cookies'))
            @include('front.components.cookies.card')
            @endif
<div data-url="{{route('mtg.specific.search','items')}}" class="redi_url">
@include('layouts.include.script')
</body>

</html>
