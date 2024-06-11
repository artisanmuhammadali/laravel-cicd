<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use App\Models\BlockUser;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BlockUserController extends Controller
{

    public function index()
    {
        $ignore = User::where('role','!=','admin')
                        ->where('id','!=',auth()->user()->id)
                        ->where('deleted_at',null)
                        ->pluck('id')->toArray();
        $list = BlockUser::where('user_id',auth()->user()->id)
                        ->whereIn('block_user_id',$ignore)
                        ->get();
        return view('user.blocked-user', get_defined_vars());
    }
     public function add($name)
    {   
        $user = User::where('user_name',$name)->first();
        $auth = auth()->user();
        $status = ['completed','refunded','cancelled'];
        $pendingOrders = Order::where(function($q) use ($auth) {
                        $q->where('seller_id', $auth->id)
                            ->orWhere('buyer_id', $auth->id);
                    })
                    ->whereNotIn('status', $status)
                    ->where(function($q) use ($user) {
                        $q->whereHas('buyer', function($q) use ($user) {
                                $q->where('id', $user->id);
                            })
                            ->orWhereHas('seller', function($q) use ($user) {
                                $q->where('id', $user->id);
                            });
                    })
                    ->count();
        if($pendingOrders >= 1)
        {
            return redirect()->back()->with('error','Please complete you orders with this user first.');
        }
        $item = New BlockUser();
        $item->user_id = $auth->id;
        $item->block_user_id = $user->id;
        $item->save();
        return redirect()->back()->with('success','Blocked Successfully!');
    }

    public function destroy($id)
    {
        BlockUser::findOrFail($id)->delete();
        return redirect()->back()->with('success','Unblocked Successfully!');
    }
}
