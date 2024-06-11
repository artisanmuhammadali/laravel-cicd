<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use App\Models\FavUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavUserController extends Controller
{
     public function index()
    {   
         $ignore = User::where('role','!=','admin')
                        ->where('id','!=',auth()->user()->id)
                        ->where('deleted_at',null)
                        ->pluck('id')->toArray();
        $list = FavUser::where('user_id',auth()->user()->id)
                        ->whereIn('fav_user_id',$ignore)
                        ->get();
        return view('user.favourite-user.index', get_defined_vars());
    }

     public function add($name)
    {   
        $fav_user = User::where('user_name',$name)->first();
        $id = auth()->user()->id;
        $item = New FavUser();
        $item->user_id = $id;
        $item->fav_user_id = $fav_user->id;
        $item->save();
        return redirect()->back()->with('success','Added Favourite Successfully!');
    }

    public function destroy($id)
    {
        FavUser::findOrFail($id)->delete();
        return redirect()->back()->with('success','Remove Favourite Successfully!');
    }


}
