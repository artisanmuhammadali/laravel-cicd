<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCard;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(0);
        $now = now();
        $urls = $this->getStaticUrls();
        $sets = MtgSet::with('cards','childs')->whereIn('type',['special','expansion'])->select('id','slug','updated_at','code')->paginate(10);
        
        $page = $request->page ?? null;
        $lastPage = $sets->lastPage();

        return response()->view('sitemap.index',compact('urls','sets','page','lastPage','now'))->header('Content-Type', 'text/xml');
    }

    public function expantionSitemap()
    {
        set_time_limit(0);
        $sets = MtgSet::with('cards','childs')->whereIn('type',['special','expansion'])->select('id','slug','updated_at','code')->get();
        return response()->view('sitemap.expantions',compact('sets'))->header('Content-Type', 'text/xml');
    }

    public function cardsSitemap()
    {
        set_time_limit(0);
        $sets = MtgSet::with('cards')->whereIn('type',['special','expansion'])->select('id','slug','code')->take(2)->get();
        return response()->view('sitemap.cards',compact('sets'))->header('Content-Type', 'text/xml');
    }

    public function generate()
    {
        set_time_limit(0);
        $urls = $this->getMtgCardsUrls();
        dd($urls);

        $urls = $this->getStaticUrls();
        $xml = view('sitemap', compact('urls'))->render();
        // File::put(public_path('sitemap1.xml'), $xml);

        $urls = $this->getMtgUrls();
        dd($urls);
        $xml = view('sitemap', compact('urls'))->render();
        File::put(public_path('sitemap2.xml'), $xml);

        return response('Sitemap generated successfully', Response::HTTP_OK);
    }
    private function getMtgCardsUrls()
    {
        $count = 1;
        $countC = 0;
        $sets =  MtgSet::with('cards')->whereIn('type',['special','expansion'])->select('slug','id','code','type') ->chunk(50, function($sets)use($count,$countC) {
            $urls = [];
            foreach($sets as $key => $set)
            {
                foreach($set->cards as $item)
                {
                    $key = array_search($item->card_type, cardTypeSlug());
                    $urls[] = route('mtg.expansion.detail',[$item->url_slug, $key ,$item->slug]);
                }
            }
            $xml = view('sitemap', compact('urls'))->render();
            File::put(public_path('xmls2/sitemapCards'. $set->id.'.xml'), $xml);
        });
        dd($countC);
        foreach($sets as $key => $set)
        {
            $urls = [];
            foreach($set->cards as $item)
            {
                $countC++;
                $key = array_search($item->card_type, cardTypeSlug());
                $urls[] = route('mtg.expansion.detail',[$item->url_slug, $key ,$item->slug]);
            }

            $xml = view('sitemap', compact('urls'))->render();
            File::put(public_path('xmls/sitemapCards'. $count.'.xml'), $xml);
            $count++;
        }
        dd($countC);
        return $urls;
    }


    private function getStaticUrls()
    {
        $now = now();
        $urls =   [
            ['url' => route('index'), 'updated_at' => $now],
            ['url' => route('help'), 'updated_at' => $now],
        ];

        $pages = Page::get();
        foreach($pages as $page)
        {
            $urls[] = ['url' => route('page',$page->slug),'updated_at' => $page->updated_at ?? $now];
        }
        return $urls;
    }

    private function getMtgUrls()
    {
        $urls =   [
            route('mtg.index'),
            route('mtg.expansion.index'),
            route('mtg.detailedSearch'),
        ];

        $sets = MtgSet::whereIn('type',['special','expansion'])->get();
        foreach($sets as $set)
        {
            $urls[] = route('mtg.expansion.set',$set->slug);
            foreach($set->childs as $child)
            {
                $urls[] = route('mtg.expansion.type',[$set->slug,$child->set_type]);
                foreach($child->cards as $item)
                {
                    $urls[] = route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug]);
                }
            }


        }
        return $urls;
    }
}
