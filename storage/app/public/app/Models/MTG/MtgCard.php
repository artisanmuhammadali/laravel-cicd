<?php

namespace App\Models\MTG;

use App\Models\MTG\MtgSet;
use Illuminate\Support\Str;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgAttribute;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgUserCollection;
use App\Models\User;
use App\Models\BlockUser;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MtgCard extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function set()
    {
        return $this->belongsTo(MtgSet::class ,'set_code','code')->withDefault();
    }
    public function images()
    {
        return $this->hasMany(MtgCardImage::class);
    }
    public function faces()
    {
        return $this->hasMany(MtgCardFace::class);
    }
    public function collections()
    {
        return $this->hasMany(MtgUserCollection::class,'mtg_card_id','id');
    }
    public function attributes()
    {
        return $this->belongsToMany(MtgAttribute::class,'mtg_card_attributes','mtg_card_id','mtg_attribute_id');
    }
    public function seo()
    {
        return $this->hasOne(MtgCardSeo::class ,'mtg_card_id','id');

    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class ,'mtg_card_id' ,'id');    
    }
    public function scopeActive($query)
    {
         return $query->where('is_active', true);
    }
    public function getLegalCardAttribute()
    {
        $sets = ['30a','cei','ced'];
        $border_colors = ['silver','gold'];
        $set =  in_array($this->set_code,$sets) ? 'This Product is not Tournament Legal' : false;
        $border_color = in_array($this->border_color,$border_colors) ? 'This Product is not Tournament Legal' : $set;
        return $border_color;
    }
    public function getWarningMsgAttribute()
    {
        
        $specialName = mtgMeldCards();
        $name = in_array($this->name , $specialName) ? "WARNING - When putting
        up this product for sale, it is important to confirm that both cards required to make this
        card are being listed simultaneously. By agreeing to this, you can proceed with the sale.
        When purchasing this product, you will receive all cards that make this product." : false;
        $msg = $this->oversized ? 'WARNING- This card is OVERSIZED & not playable in tournaments!!!' : false;
        return $msg == false ? $name : $msg;    
    }
    public function getCardMsgAttribute()
    {
        $oversize = $this->oversized ? 'Oversized & Non-Tournament Legal' : false;
        $specialName = mtgMeldCards();
        $name = in_array($this->name , $specialName) ? "This card is made of 2 different cards" : false;
        $attr = $this->name_attr != "" ? $this->name_attr : false;
        $msg = $this->legalCard != false ? $this->legalCard : false;  
        $msg = $msg == false ? $attr : $msg;  
        $msg = $msg == false ? $name: $msg;
        return $msg == false ?  $oversize : $msg;
    }
    public function getAuthCollectionAttribute()
    {
        return $this->collections->where('user_id',auth()->user()->id)->where('quantity','!=',0);    
    }
    public function getVersionsAttribute()
    {
        $cards  =MtgCard::where('id','!=',$this->id)
                    ->where('name',$this->name)
                    ->get();
        $set_code = $this->set_code;
        $versions = $cards->sortBy(function ($card) use ($set_code) {
            return $card->set_code === $set_code ? 0 : 1;
        });
        return $versions;
    }
    public function getNameAttrAttribute()
    {
        if($this->attributes)
        {
            $attributes = $this->attributes();
            $attributes = $attributes->pluck('name')->toArray();
            return implode(' ',$attributes);
        }
        return "";

    }
    public function getAveragePriceAttribute()
    {
        $now = Carbon::now();
        $orderDetail = OrderDetail::where('mtg_card_id',$this->id);
        $one = "£ ".round($orderDetail->where('created_at','>=',$now->subDay())->avg('price'));
        $seven = "£ ".round($orderDetail->where('created_at','>=',$now->subDays(7))->avg('price'));
        $thirty = "£ ".round($orderDetail->where('created_at','>=',$now->subDays(30))->avg('price'));
        $all = "£ ".round($orderDetail->avg('price'));

        $avg = [
            'one'=>$one == '£ 0' ? 'Not Available' : $one,
            'seven'=>$seven == '£ 0' ? 'Not Available' : $seven,
            'thirty'=>$thirty == '£ 0' ? 'Not Available' : $thirty,
            'all'=>$all == '£ 0' ? 'Not Available' : $all,
        ];
        return (object)$avg;    
    }
    public function getListingCollectionAttribute()
    {
        $user_ids = User::where('verified',1)->where('status','active')->pluck('id')->toArray();
        if(auth()->user()){
            $block_users = BlockUser::where('user_id',auth()->user()->id)->pluck('block_user_id')->toArray();
            $block_by = BlockUser::where('block_user_id',auth()->user()->id)->pluck('user_id')->toArray();
            $block_ids = array_merge($block_by , $block_users);
            $ids = array_diff($user_ids , $block_ids);
            return $this->collections->whereIn('user_id',$ids)->where('quantity','!=',0)->where('publish',1);
        }
        else{
            return $this->collections->whereIn('user_id',$user_ids)->where('quantity','!=',0)->where('publish',1);
        }
    }
    public function getUrlSlugAttribute()
    {
        return  $this->set->type == "child" && $this->set->parent ? $this->set->parent->slug : $this->set->slug;
    }
    public function getUrlTypeAttribute()
    {
        if($this->set->type == "special" || $this->set->type == "expansion")
        {
            $index = array_search($this->card_type,cardTypeSlug());
            return $index ? $index : 'single-cards';
        }
        if($this->set->custom_type == 'singles')
        {
            return $this->set->slug;
        }
        return Str::slug($this->set->custom_type);
    }
    public function getPngImageAttribute(){
        if($this->card_type != "completed")
        {
            $img = $this->images ? $this->images->where('value','!=',null)->where('key','png')->first() : null;
            return $img ? $img->value : 'https://errors.scryfall.com/soon.jpg';
        }
        else{
            return $this->set->icon ?? 'https://beta.veryfriendlysharks.co.uk/upload/expansion/All.svg';
        }
    }
    public function getDoubleImageAttribute(){
        $defaultImgs = ['https://errors.scryfall.com/soon.jpg' ,'https://errors.scryfall.com/soon.jpg'];
        if($this->images)
        {
            $img = $this->images->where('value','!=',null)->where('key','png')->pluck('value')->toArray();
            return array_key_exists(0 ,$img) && $img[0] ? $img : $defaultImgs;
        }
        else{
            return $defaultImgs;
        }
    }
    public function getPriceStartsFromAttribute()
    {
        return  $this->listing_collection->min('price');
    }
    public function getFoilItemAttribute()
    {
        return $this->listing_collection->where('foil',1)->first();
    }
    public function getNonFoilItemAttribute()
    {
        return $this->listing_collection->where('foil',0)->first();
    }
    public function getCardFoilAttribute()
    {
        if($this->card_type == "single")
        {
            // $this->foil == 1 && $this->nonfoil == 1; // true then both
            // $this->foil == 0 && $this->nonfoil == 0; // true then etched foil
            // $this->foil == 1 && $this->nonfoil == 0; // true then foil only
            // $this->foil == 0 && $this->nonfoil == 1; // true then check finishes

            $condition = checkCardFoiling($this->foil , $this->nonfoil);
            $array = [
                'Foil'=> ['checked',''],
                'Both'=> ['' , ''],
            ];

            $check = $condition == "NonFoil" ? checkCardFinishes($this->finishes) :$array[$condition] ;

            $attr = $check[0];
            $class= $check[1];
        }
        else{
            $foil = $this->set->foil;
            $attr = $foil == 0 ? 'disabled' : '';
            $class = $foil == 0 ? 'disable-foil' : '';

        }
        return (object) ['attr' => $attr , 'class'=>$class];
    }
    public function language()
    {
        return $this->hasMany(MtgCardLanguage::class,'mtg_card_id','id');
    }
    public function getIsLegalAttribute()
    {
        if($this->legalities && $this->legalities != '[]'){
            $legalCount = array_reduce(json_decode($this->legalities , true), function ($carry, $value) {
                return $carry + ($value === 'legal' ? 1 : 0);
            }, 0);
            return $legalCount == 0 ? false : true;
        }
        return false;
    }
    public function getCardLanguagesAttribute()
    {
        return $this->language->count() > 0 ?  $this->language->pluck('value','key')->toArray() : null;
    }
    public function getBestPriceCardsAttribute()
    {
        return $this->listing_collection->sortBy('price')->values()->take(5);
    }
}
