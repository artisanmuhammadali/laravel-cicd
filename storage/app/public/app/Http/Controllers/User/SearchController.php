<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCard;

class SearchController extends Controller
{
    public function generalSearch(Request $request)
    {
       $list = MtgCard::active()->where('name', 'like', '%' . $request->keyword. '%')->where('card_type',$request->card_type)->latest()->get();
       $count = count($list);
       $view  = view('user.components.search.list',get_defined_vars())->render();

       return response()->json(['html' => $view , 'count'=>$count]);
    }
}
