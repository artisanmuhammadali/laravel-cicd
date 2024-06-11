    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('metaTag')
    <title>@yield('title')</title>
    <meta name="keywords" content="magic the gathering, card market, mtg, trading cards, very friendly sharks, vfs mtg, vfs uk, vfs, magic the gathering cards, magic card market, magic singles, mtg cards, mtg singles uk, uk mtg singles, sell mtg cards uk, buy mtg cards uk">
    <meta name="description" content="@yield('description')">
    @if(Route::is('mtg.detailed.search') || Route::is('mtg.specific.search') || Route::is('profile.index') || Route::is('mtg.newly.collection.type') || Route::is('mtg.newly.collection') || Route::is('mtg.featured.items.type') || Route::is('mtg.marketplace'))
    <meta name="robots" content="noindex,follow">
    @endif
    <link rel="icon" type="image/x-icon" href="{{$setting['favicon'] ?? ''}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @if(count($announcements) > 0)
        <link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Owl_carousel/css/owl.theme.default.min.css') }}">
    @endif
    @stack('css')
    @vite('resources/css/app.scss')