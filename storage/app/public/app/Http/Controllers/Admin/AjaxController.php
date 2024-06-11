<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getPage(Request $request)
    {
         $view = view('front.components.pages.'.$request->page)->render();

         return response()->json(['view' => $view]);
    }
}
