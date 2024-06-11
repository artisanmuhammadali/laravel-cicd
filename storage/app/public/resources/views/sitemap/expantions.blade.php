<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($sets as $set)
        @include('sitemap.components.locationSection',['url' => route('mtg.expansion.set',$set->slug)])
        @foreach($set->childs as $child)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,$child->set_type])])
            @foreach($child->cards as $item)
                @include('sitemap.components.locationSection',['url' => route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug])])
            @endforeach
        @endforeach
    @endforeach
</urlset>