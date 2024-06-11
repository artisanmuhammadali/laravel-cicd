<?php

namespace App\Models;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgUserCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable =[
      'order_id',
      'mtg_card_id',
      'price',
      'quantity',
      'mtg_user_collection_id',
      'collection_type',
      'card_type',
      'card_id',
      'collection_id',
      'language',
      'condition',
      'foil',
      'signed',
      'altered',
      'graded',
      'image',
      'note',
      'collection_price',
      'range'
  ];

    public function card()
    {
       return $this->morphTo();
    }
    public function userCollection()
    {
        return $this->morphTo();
    }
    public function getCollectionAttribute()
    {
      $obj = [
         'language'=>$this->language,
         'foil'=>$this->foil,
         'signed'=>$this->signed,
         'altered'=>$this->altered,
         'graded'=>$this->graded,
         'condition'=>$this->condition,
         'image'=>$this->image,
         'img'=>$this->image ? 'https://img.veryfriendlysharks.co.uk/'.$this->image : asset('images/expansion/Placeholder.svg'),
         'note'=>$this->note,
         'price'=>$this->price,
         'mtg_card_type'=>$this->card->type,
      ];
      return (object)$obj;
    }
}
