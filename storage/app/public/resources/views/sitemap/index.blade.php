<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @if(!$page)
       @for($i=1 ;$i<= $lastPage; $i++)
       <url>
         <loc>{{route('sitemap.xml')}}?page={{$i}}</loc>
         <changefreq>weekly</changefreq>
         <lastmod>{{customDate($now,'Y-m-d\TH:i:sP')}}</lastmod>
         <priority>0.9</priority>
       </url>
       @endfor
    @else
    @if($page == 1)
    @foreach($urls as $urll)
    @include('sitemap.components.locationSection',['url' => $urll['url'],'updated_at' => customDate($urll['updated_at'],'Y-m-d\TH:i:sP')])
    @endforeach
    @endif
    @foreach($sets as $set)
        @include('sitemap.components.locationSection',['url' => route('mtg.expansion.set',$set->slug),'updated_at' => customDate($set->updated_at,'Y-m-d\TH:i:sP')])
        @foreach($set->childs as $child)
        @php($type = $child->custom_type == "singles" ? $child->slug :$child->set_type) 
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,$type]),'updated_at' => customDate($child->updated_at,'Y-m-d\TH:i:sP')])
            @foreach($child->cards as $item)
                @include('sitemap.components.locationSection',['url' => route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug]),'updated_at' => customDate($item->updated_at,'Y-m-d\TH:i:sP')])
            @endforeach
        @endforeach

        @if($set->single_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'single-cards']),'updated_at' => customDate($set->updated_at,'Y-m-d\TH:i:sP')])
        @endif
        @if($set->sealed_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'sealed-products']),'updated_at' => customDate($set->updated_at,'Y-m-d\TH:i:sP')])
        @endif
        @if($set->completed_count > 0)
            @include('sitemap.components.locationSection',['url' => route('mtg.expansion.type',[$set->slug,'complete-sets']),'updated_at' => customDate($set->updated_at,'Y-m-d\TH:i:sP')])
        @endif

        @foreach($set->cards as $item)
                @php($key = array_search($item->card_type, cardTypeSlug()))
                @include('sitemap.components.locationSection',['url' => route('mtg.expansion.detail',[$item->url_slug, $key ,$item->slug]),'updated_at' => customDate($item->updated_at,'Y-m-d\TH:i:sP')])
        @endforeach
      
    @endforeach
    @endif
</urlset>
