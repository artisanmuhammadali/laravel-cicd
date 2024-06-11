<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddressRequest;
use App\Models\Order;
use App\Models\UserAddress;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AddressControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = UserAddress::where('user_id',auth()->user()->id)->get();
        return view('user.address.index' , get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function loadModal($id = null)
    {
        $address = $id != null ? UserAddress::findOrFail($id) : null;
        return view('user.address.form',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $user_id = auth()->user()->id;
        $request->merge(['user_id'=> $user_id]);
        if($request->type == "primary")
        {
            UserAddress::where('user_id',$user_id)->update(['type'=>'secondary']);
        }
        UserAddress::updateOrCreate(['id' => $request->id],$request->except('_token'));
        $msg = $request->id ?  "Address Updated Successfully!" : "Address Created Successfully!";

        return response()->json(['success'=>$msg , 'redirect'=>route('user.address.index')]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::where('address',$id)->first();
        if($order)
        {
            return redirect()->back()->with('error','This address is associate with your order you cannot delete.');
        }
        UserAddress::findOrFail($id)->delete();
        return redirect()->back()->with('success','Address Deleted Successfully!');
    }
}
