<?php

namespace App\Http\Controllers\Test;

use GuzzleHttp\Client;
use App\Models\MTG\MtgSet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class SetImportController extends Controller
{
    public function sets()
    {
        return;
        #CLIENT HTTP CALL TO GET SETS JSON
        $client = new Client();
        $response = $client->get('https://api.scryfall.com/sets');
        $response = json_decode($response->getBody()->getContents(), true);

        $set=0;
        $exp=0;
        $rem=0;

        foreach ($response['data'] as $key => $item)
        {

            #CHECK DIGITAL AND RELEASED DATE
            if($this->checkReleasedAndDigital($item['released_at'], $item['digital']) == false) continue;

            #CHECK SET TYPE
            if($this->checkSetType($item['set_type']) == false)
            {
                #CHECK PARENT SET EXIST
                if(array_key_exists('parent_set_code', $item))
                {
                    // CREATE SET RECORD
                    $this->createSet($item, 'special');
                // $set++;

                }
                else
                {
                    // $rem++;
                    $this->createSet($item, 'special');

                }


                continue;
            }

            #CREATE EXPANSION RECORD
            // $exp++;
            $this->createSet($item, 'expansion');

        }

        dd('done...');

    }
    public function match()
    {


        $data = '[{"code":"pl23"},{"code":"pone"},{"code":"onc"},{"code":"scd"},{"code":"j22"},{"code":"30a"},{"code":"pewk"},{"code":"brc"},{"code":"bot"},{"code":"pbro"},{"code":"rtecsharks"},{"code":"unf"},{"code":"40k"},{"code":"pdmu"},{"code":"dmc"},{"code":"p30a"},{"code":"psvc"},{"code":"sch"},{"code":"2x2"},{"code":"pclb"},{"code":"clb"},{"code":"ncc"},{"code":"psnc"},{"code":"pncc"},{"code":"gdy"},{"code":"sdsharks"},{"code":"pl22"},{"code":"pdg"},{"code":"pneo"},{"code":"nec"},{"code":"cdsharks"},{"code":"cc2"},{"code":"dbl"},{"code":"pvow"},{"code":"voc"},{"code":"mic"},{"code":"pmid"},{"code":"pafr"},{"code":"afc"},{"code":"pmh2"},{"code":"mh2"},{"code":"h1r"},{"code":"pstx"},{"code":"c21"},{"code":"tsr"},{"code":"pkhm"},{"code":"khc"},{"code":"pl21"},{"code":"cc1"},{"code":"cmr"},{"code":"plist"},{"code":"pznr"},{"code":"znc"},{"code":"2xm"},{"code":"jmp"},{"code":"pm21"},{"code":"ss3"},{"code":"piko"},{"code":"c20"},{"code":"und"},{"code":"pthb"},{"code":"sld"},{"code":"mb1"},{"code":"ptg"},{"code":"peld"},{"code":"c19"},{"code":"ps19"},{"code":"ppp1"},{"code":"pm20"},{"code":"ss2"},{"code":"mh1"},{"code":"pwar"},{"code":"gk2"},{"code":"prna"},{"code":"uma"},{"code":"prwk"},{"code":"gk1"},{"code":"pgrn"},{"code":"med"},{"code":"c18"},{"code":"ps18"},{"code":"pm19"},{"code":"gs1"},{"code":"ss1"},{"code":"pbbd"},{"code":"bbd"},{"code":"cm2"},{"code":"pdom"},{"code":"ddu"},{"code":"a25"},{"code":"plny"},{"code":"pnat"},{"code":"prix"},{"code":"ust"},{"code":"e02"},{"code":"v17"},{"code":"ima"},{"code":"ddt"},{"code":"g17"},{"code":"pxln"},{"code":"h17"},{"code":"c17"},{"code":"ps17"},{"code":"phou"},{"code":"e01"},{"code":"cma"},{"code":"pakh"},{"code":"mp2"},{"code":"w17"},{"code":"dds"},{"code":"mm3"},{"code":"paer"},{"code":"pca"},{"code":"c16"},{"code":"ps16"},{"code":"pkld"},{"code":"ddr"},{"code":"cn2"},{"code":"v16"},{"code":"pemn"},{"code":"ema"},{"code":"psoi"},{"code":"w16"},{"code":"ddq"},{"code":"pogw"},{"code":"c15"},{"code":"pbfz"},{"code":"ddp"},{"code":"v15"},{"code":"cp3"},{"code":"pori"},{"code":"ps15"},{"code":"mm2"},{"code":"pdtk"},{"code":"ddo"},{"code":"pfrf"},{"code":"cp2"},{"code":"ugin"},{"code":"jvc"},{"code":"evg"},{"code":"gvl"},{"code":"dvd"},{"code":"c14"},{"code":"pktk"},{"code":"ddn"},{"code":"v14"},{"code":"cp1"},{"code":"ps14"},{"code":"cns"},{"code":"md1"},{"code":"ddm"},{"code":"pi14"},{"code":"c13"},{"code":"ddl"},{"code":"v13"},{"code":"psdc"},{"code":"mma"},{"code":"wmc"},{"code":"ddk"},{"code":"pi13"},{"code":"cm1"},{"code":"ddj"},{"code":"v12"},{"code":"pc2"},{"code":"phel"},{"code":"ddi"},{"code":"cfoshark"},{"code":"rtpshark"},{"code":"rtlcshark"},{"code":"rtlgcshark"},{"code":"pidw"},{"code":"pd3"},{"code":"ddh"},{"code":"v11"},{"code":"cmd"},{"code":"ddg"},{"code":"pmps11"},{"code":"ps11"},{"code":"olgc"},{"code":"pd2"},{"code":"ddf"},{"code":"v10"},{"code":"arc"},{"code":"parc"},{"code":"dpa"},{"code":"dde"},{"code":"pmps10"},{"code":"h09"},{"code":"ddd"},{"code":"hop"},{"code":"phop"},{"code":"v09"},{"code":"ddc"},{"code":"purl"},{"code":"pbook"},{"code":"pmps09"},{"code":"dd2"},{"code":"drb"},{"code":"p15a"},{"code":"pmps08"},{"code":"dd1"},{"code":"psum"},{"code":"pgpx"},{"code":"ppro"},{"code":"pres"},{"code":"pmps07"},{"code":"hho"},{"code":"pcmp"},{"code":"pmps06"},{"code":"pjas"},{"code":"phuk"},{"code":"p2hg"},{"code":"psal"},{"code":"pmps"},{"code":"pjse"},{"code":"unh"},{"code":"wc04"},{"code":"wc03"},{"code":"pjjt"},{"code":"ovnt"},{"code":"wc02"},{"code":"phj"},{"code":"dkm"},{"code":"wc01"},{"code":"btd"},{"code":"wc00"},{"code":"s00"},{"code":"pelp"},{"code":"psus"},{"code":"brb"},{"code":"o9x12sharks"},{"code":"pwos"},{"code":"pwor"},{"code":"wc99"},{"code":"pgru"},{"code":"ptk"},{"code":"s99"},{"code":"ath"},{"code":"palp"},{"code":"wc98"},{"code":"ugl"},{"code":"p02"},{"code":"wc97"},{"code":"olep"},{"code":"por"},{"code":"pvan"},{"code":"pmic"},{"code":"itp"},{"code":"mgb"},{"code":"pred"},{"code":"pcel"},{"code":"plgm"},{"code":"rqs"},{"code":"ptc"},{"code":"o90p"},{"code":"rin"},{"code":"ren"},{"code":"chr"},{"code":"bchr"},{"code":"pmei"},{"code":"phpr"},{"code":"pdrc"},{"code":"sum"},{"code":"cei"},{"code":"htrpsharks"},{"code":"palpsharks"},{"code":"fnmpsharks"},{"code":"gntpsharks"},{"code":"pgpsharks"},{"code":"plgpsharks"},{"code":"pfpsharks"},{"code":"mprpsharks"},{"code":"pwpnpsharks"},{"code":"pdtpsharks"},{"code":"llpskarks"},{"code":"jgcpsharks"}]';

        $data = json_decode($data, true);
        $data_codes = array_column($data, 'code');


        $mysets = MtgSet::where('type', 'special')->get(['id','code','type']);



        foreach ($mysets as $key => $item)
        {

            if(in_array($item->code, $data_codes))
            {
                $item->parent_set_code = null;
            }
            else
            {
                $item->type = 'child';
            }

            $item->save();

        }

        dd('done...');

    }

    public function checkReleasedAndDigital($released, $digital)
    {
        if($released < now()->format('Y/m/d') && $digital == false)
        {
            return true;
        }
        return false;
    }
    public function checkSetType($type)
    {
        if($type == 'expansion' || $type == 'core')
        {
            return true;
        }
        return false;
    }

    public function createSet($item, $type)
    {
        MtgSet::create([
                'uuid' => $item['id'],
                'code' => $item['code'],
                'name' => $item['name'],
                'slug' => Str::Slug($item['name']),
                'set_type' => $item['set_type'],
                'card_count' => $item['card_count'],
                'parent_set_code' => $item['parent_set_code'] ?? null,
                'icon' => $item['icon_svg_uri'],
                'type' => $type,
                'released_at' => $item['released_at'],
        ]);
    }

   public function getSeoDetail()
   {
    $contents = File::get(public_path('test/setSeoDetail.json'));
     $rows = json_decode($contents);
    //  dd(count($rows));
    $data = [];
    $count = 0;
    $count2 = 0;
     foreach($rows as $row)
     {
        $count++;
        $set =  MtgSet::where('code',$row->code)->first();
        if($set)
        {
            $count2++;
            $set->title = $row->expansion_detail->title ?? null;
            $set->heading = $row->expansion_detail->heading1 ?? null;
            $set->sub_heading = $row->expansion_detail->heading2 ?? null;
            $set->meta_description = $row->expansion_detail->meta_description ?? null;
            $set->slug = $row->expansion_detail->url ?? null;
            $set->save();
        }
        else{
            $data[] = $row->code;
        }
     }

     dd($count,$count2,$data);
   }

   public function updateSets()
   {
        $client = new Client();
        $response = $client->get('https://api.scryfall.com/sets');
        $response = json_decode($response->getBody()->getContents(), true);

        foreach ($response['data'] as $key => $item)
        {
            $item = (object) $item;
            $set = MtgSet::where('code',$item->code)->first();
            if($set)
            {
                $set->foil = $item->foil_only;
                $set->nonfoil = $item->nonfoil_only;
                $set->save();
            }
        }
        return "done sets updated..";

   }
}
