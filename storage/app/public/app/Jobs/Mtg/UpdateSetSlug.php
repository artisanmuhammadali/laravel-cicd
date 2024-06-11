<?php

namespace App\Jobs\Mtg;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSetSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $set;
    private $before_slug;
    private $after_slug;
    /**
     * Create a new job instance.
     */
    public function __construct($set , $before_slug , $after_slug)
    {
        $this->set = $set;
        $this->before_slug = $before_slug;
        $this->after_slug = $after_slug;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        createOrUpdateRedirect(route('mtg.expansion.set',[$this->before_slug]) ,route('mtg.expansion.set',[$this->after_slug]));
        foreach($this->set->childs as $child){
            $type = $child->type == "singles" ? $child->slug :$child->set_type;
            createOrUpdateRedirect(route('mtg.expansion.type',[$this->before_slug,$type]),route('mtg.expansion.type',[$this->after_slug,$type]));
            foreach($child->cards as $item){
                createOrUpdateRedirect(route('mtg.expansion.detail',[$item->url_slug, $item->url_type ,$item->slug]),route('mtg.expansion.detail',[setUrlSlug($item ,$this->after_slug), setUrlType($item , $this->after_slug) ,$item->slug]));
            }
        }
        if($this->set->single_count > 0){
            createOrUpdateRedirect(route('mtg.expansion.type',[$this->before_slug,'single-cards']),route('mtg.expansion.type',[$this->after_slug,'single-cards']));
        }
        if($this->set->sealed_count > 0){
            createOrUpdateRedirect(route('mtg.expansion.type',[$this->before_slug,'sealed-products']),route('mtg.expansion.type',[$this->after_slug,'sealed-products']));
        }
        if($this->set->completed_count > 0){
            createOrUpdateRedirect(route('mtg.expansion.type',[$this->before_slug,'complete-sets']),route('mtg.expansion.type',[$this->after_slug,'complete-sets']));
        }
        foreach($this->set->cards as $item){
            $key = array_search($item->card_type, cardTypeSlug());
            createOrUpdateRedirect(route('mtg.expansion.detail',[$item->url_slug, $key ,$item->slug]),route('mtg.expansion.detail',[setUrlSlug($item ,$this->after_slug), $key ,$item->slug]));
        }
        return true;
    }
}
