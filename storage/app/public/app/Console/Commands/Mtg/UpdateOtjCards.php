<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardImage;
use App\Services\Admin\MTG\UpdateCards;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateOtjCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:update-otj-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UpdateCards $service)
    {
        set_time_limit(0);
        $codes = ['otj','otp','totp','potj','totj','yotj','aotj','big','tbig','otc','totc'];
        $cards = MtgCard::whereIn('set_code',$codes)->where('card_id','!=',null)->whereDate('updated_at', '!=', Carbon::today())->get();
        foreach($cards as $card)
        {
            $url = 'https://api.scryfall.com/cards/'.$card->card_id;
            $this->apiCall($url , $card);
        }
        return 'done..';
    }
    public function apiCall($url , $card)
    {
        $client = new Client();
        $response = $client->get($url);
        $item = json_decode($response->getBody()->getContents(), true);

        $has_face = array_key_exists('card_faces', $item);
        $images = [];
        if($has_face)
        {
            foreach($item['card_faces'] as $key => $itemm)
            {
               $images[] = isset($itemm['image_uris']) ? $itemm['image_uris'] : (isset($item['image_uris']) ? $item['image_uris'] : null);
            }
        }
        else{
            $images[] = isset($item['image_uris']) ? $item['image_uris'] : null;
        }

        $this->updateCardImages($card, $images);
    }
    public function updateCardImages($card, $images)
    {
        DB::table('mtg_card_images')->where('mtg_card_id',$card->id)->where('value',null)->delete();
        $default_images = DB::table('mtg_card_images')->where('mtg_card_id',$card->id)->get();

        foreach($images as $key => $image)
        {
            $default_img =  isset($default_images[$key]) ? $default_images[$key] : null;
            $this->saveImageData($image,$card->id,$default_img);
        }
        return true;
    }
    public function saveImageData($data,$card_id,$default_img = null)
    {
        $url = $data && isset($data['png']) ? $data['png'] : null;
        $value = $default_img  ?  $default_img->value : null;
        $this->saveImageUrlToFile($value);
        // $value = $default_img && $default_img->default_url == $url ?  $default_img->value : $url;

        $data = [
            'mtg_card_id' => $card_id,
            'key' => 'png',
            'value' => $url,
            'default_url' => $url,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
        $query = ['mtg_card_id' => $card_id,'id' => $default_img ? $default_img->id : null ];
        MtgCardImage::updateOrInsert($query ,$data);
    }
    public function saveImageUrlToFile($url = null)
    {
        $filePath = public_path('mtg/sets/media/url.json');
       // Data to append to the file
        $data = $url."\n";

        // Check if the file exists
        if (file_exists($filePath)) {
    // Append data to the file
        file_put_contents($filePath, $data, FILE_APPEND);
        } else {
    // Create the file and write data to it
        file_put_contents($filePath, $data);
        }
    } 
}
