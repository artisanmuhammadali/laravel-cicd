<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($sets as $set)
        @if($set->single_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'single-cards'])])
        @endif
        @if($set->sealed_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'sealed-products'])])
        @endif
        @if($set->completed_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'complete-sets'])])
        @endif
        @foreach($set->cards as $item)
            @php($key = array_search($item->card_type, cardTypeSlug()))
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.detail',[$item->url_slug, $key ,$item->slug])])
        @endforeach
    @endforeach
</urlset>