<?php

namespace App\Services\Admin\MTG;

use App\Jobs\Mtg\UpdateSetSlug;
use App\Models\MTG\MtgSet;
use App\Models\Mtg\MtgSetSeo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SetsServices {
 
     public function createService($request)
     {
      
        if($request->type == 'new_arrival')
        {
           $request['type'] = 'single';
           $request['is_active'] = 0;
        }
        $slug = Str::slug($request->name);
        $request['slug'] = $slug;
        $request = $this->saveSetMedia($request);
       return DB::table('mtg_sets')->insert($request->except(['_token','icon_img','banner_img']));
     }

     public function seoManagement($request,$id)
     {
         if(!$request->type)
         {
            $set = MtgSet::findOrFail($id);
            $request = $this->saveSetMedia($request);
            if($set->slug != $request->slug)
            {
               dispatch(new UpdateSetSlug($set , $set->slug , $request->slug));
            }
            $set->update($request->except('_token','banner_img','icon_img'));
         }
         else{
            $data =[
               'mtg_set_id'=>$id,
               'title'=>$request->title,
               'heading'=>$request->heading,
               'sub_heading'=>$request->sub_heading,
               'meta_description'=>$request->meta_description,
               'type'=>$request->type,
               'created_at'=>now(),
               'updated_at'=>now(),
             ];
            $query = ['mtg_set_id'=>$id , 'type'=>$request->type];
            MtgSetSeo::updateOrInsert($query , $data);
         }
         return true;
     }

     public function saveSetMedia($request)
     {
        if($request->icon_img)
        {
            $image = uploadFile($request->icon_img,$request->slug.'_icon','custom');
            $request->merge(['icon' => $image]);
        }
        if($request->banner_img)
        {  
            $image = uploadFile($request->banner_img,$request->slug.'_banner','custom');
            $request->merge(['banner' => $image]);
        }
        
        return $request;
     }
}