<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateInfoRequest;
use App\Http\Requests\User\SellerAccountRequest;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserAddress;
use App\Services\User\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Services\Auth\RegisterServices;
use Auth;

class ProfileController extends Controller
{
    private $registerServices;
    public function __construct(RegisterServices $registerServices)
    {
        $this->registerServices = $registerServices;
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
        Auth::guard('web')->logout();
        return redirect()->route('index')->with('success','Password has changed successfully!');
    }
    public function updateInfo(UpdateInfoRequest $request)
    {   
        $column = $request->table_name == 'users' ? 'id' : 'user_id';
        DB::table($request->table_name)->where($column,auth()->user()->id)->update($request->except('_token','table_name'));
        if($request->email){
            event(new Registered(auth()->user()));
        }
        return response()->json(['success'=>'Information has Updated Successfully!']);
    }
    public function updateAvatar(Request $request)
    {
        if($request->hasFile('photo'))
        { 
            $validateUser = Validator::make($request->all(), 
            [
                'photo' => ['mimes:jpeg,png,jpg','max:5048'],
            ]);

            if($validateUser->fails()){
                return redirect()->back()->with('error','Formats must be jpeg,png,jpg and maximum size is 5MB.');
            }
            $imageName = time() . '.' . $request->photo->extension();
            $fileUplaod = uploadFile($request->photo,$imageName ,'custom');
            User::find(auth()->user()->id)->update(['avatar'=> $fileUplaod]);
        }
        return redirect()->route('user.account')->with('success','Profile Image has Updated Successfully!');
    }

    public function updateRole($role)
    {
        User::find(auth()->user()->id)->update(['role'=> $role]);
        return redirect()->route('user.account')->with('success','Account Type has uploaded Successfully!');
    }

    
   
}
