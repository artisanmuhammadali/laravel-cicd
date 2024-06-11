<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\UserStore;
use Illuminate\Support\Facades\DB;
use App\Models\Conversation;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MTG\MtgUserCollection;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles , SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'dob',
        'email_verified_at',
        'password',
        'avatar',
        'role',
        'current_role',
        'status',
        'about_portal',
        'referr_by',
        'type',
        'verified',
        'ubo_verify',
        'kyc_verify'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function scopeOther($query)
    {
        $block_id = BlockUser::where('user_id',auth()->user()->id)->pluck('block_user_id')->toArray();
        $this_id = [auth()->user()->id];
        $not_ids = array_merge($block_id , $this_id);
        return $query->whereNotIn('id',$not_ids);
    }

    public function scopeChatUsers($query)
    {
        $authId = auth()->user()->id;
        $conversations = DB::table('conversations')
        ->select('receiver_id as user_id', 'updated_at')
        ->where('sender_id', $authId)
        ->orWhere('receiver_id', $authId)
        ->groupBy('receiver_id')
        ->orderBy('updated_at', 'desc');
    
    $senderIds = DB::table('conversations')
        ->select('sender_id as user_id', 'updated_at')
        ->where('receiver_id', $authId)
        ->groupBy('sender_id')
        ->union($conversations)
        ->orderBy('updated_at', 'desc')
        ->pluck('user_id');

        return $query->whereIn('id',$senderIds);
    }

    public function scopeContactUsers($query)
    {
        $userIds = Conversation::whereHas('messages')->where(function($q){
            $q->where('receiver_id',auth()->user()->id)->orWhere('sender_id',auth()->user()->id);
        })->select('receiver_id')
        ->union(Conversation::whereHas('messages')->where(function($q){
            $q->where('receiver_id',auth()->user()->id)->orWhere('sender_id',auth()->user()->id);
        })->select('sender_id'))
        ->pluck('receiver_id');

        return $query->whereNotIn('id',$userIds);
    }

    /**
     * Get the store associated with the user.
     */
    public function store()
    {
        return $this->hasOne(UserStore::class);
    }
    public function address()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function buyingOrders()
    {
        return $this->hasMany(Order::class,'buyer_id' , 'id');
    }
    public function reportTo()
    {
        return $this->hasMany(Support::class,'report_to_id');
    }
    public function cancelledBy()
    {
        return $this->hasMany(Order::class,'cancelled_by');
    }

    public function reportBy()
    {
        return $this->hasMany(Support::class,'report_by_id');
    }
    public function sendingEmail()
    {
        return $this->hasMany(EmailMarkting::class, 'sent_by','id');
    }
    public function ReceiveEmail()
    {
        return $this->hasMany(UserEmail::class, 'user_id','id');
    }
    public function sellingOrders()
    {
        return $this->hasMany(Order::class, 'seller_id','id');
    }
    public function favUser()
    {
        return $this->hasMany(FavUser::class, 'fav_user_id' , 'id');
    }
    public function blockUser()
    {
        return $this->hasMany(BlockUser::class , 'block_user_id' , 'id');
    }
    public function sellerProgram()
    {
        return $this->hasOne(SellerProgram::class,'user_id');
    }
    public function referr()
    {
        return $this->belongsTo(User::class,'referr_by' , 'id')->withTrashed();
    }
    public function referredUsers()
    {
        return $this->hasMany(User::class,'referr_by')->withTrashed();
    }
    public function wallets()
    {
        return $this->hasMany(UserWallet::class,'user_id');
    }
    public function collections()
    {
        return $this->hasMany(MtgUserCollection::class,'user_id');
    }
    public function sw_collections()
    {
        return $this->hasMany(UserCollection::class,'user_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class , 'credit_user' ,'debit_user');
    }
    public function reviews()
    {
        return $this->hasMany(OrderReview::class ,'review_to' ,'id');
    }
    public function kycs()
    {
        return $this->hasMany(UserKyc::class,'user_id')->where('key','!=','ubo');
    }
    public function kyb()
    {
        return $this->hasOne(UserKyc::class,'user_id')->where('key','ubo');
    }
    public function getBlockByAuthAttribute()
    {
        return auth()->user() ? $this->blockUser->where('user_id',auth()->user()->id)->first() : false;
    }
    public function getVfsWalletAttribute()
    {
        return (int)$this->store->vfs_wallet;
    }
    public function getFavByAuthAttribute()
    {
        $return = auth()->user() ? $this->favUser->where('user_id',auth()->user()->id)->first() : false;
        return $return;
    }
    public function getSellerAddressAttribute()
    {
        if($this->address){
            $address = $this->address->where('type','primary')->first();
            $address = $address ? $address : $this->address->where('type','secondary')->first();
            $address = $address ?? null;
            return $address;
        }
        return null;
    }
    public function  getFullNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }
    public function  getDateOfBirthAttribute()
    {
        return \Carbon\Carbon::parse($this->dob)->format('Y/m/d');
    }
    public function  getDobViewAttribute()
    {
        return \Carbon\Carbon::parse($this->dob)->format('Y-m-d');
    }
    public function  getPhoneAttribute()
    {
        if($this->store){
            return "+44 ".$this->store->telephone;
        }
        return null;
    }
    public function getMainImageAttribute()
    {
        if($this->avatar)
        {
            return 'https://img.veryfriendlysharks.co.uk/'.$this->avatar;
        }
        return asset('images/default.png');
    }
    public function getPrimaryAddressAttribute()
    {
        if($this->address)
        {
            $data = $this->address->where('type','primary')->first();
            if($data){
                return $data->street_number ." ,". $data->city ." ,". $data->country;
            }
        }

        return "-";
    }
    public function getAverageRatingAttribute()
    {
            $count = $this->reviews->count();
            $sum = $this->reviews->sum('rating');
            $avg =  $count ? $sum/$count : 0;
            return number_format((float)$avg, 1, '.', '');
    }
    public function getTierBadgeAttribute()
    {
        $order = $this->sellingOrders;
        $rating = $this->average_rating;
        $tier = false;

        if (count($order) > 500 && $rating >= 4.0) {
            $tier = true;
        }
        return $tier;
    }
    public function getDispatchBadgeAttribute()
    {
        $return = (object)['lable'=>"" , 'day'=>0];

        $orders = Order::where('seller_id',$this->id)
                        ->where('status','completed')
                        ->where('dispatch_at','!=',null)
                        ->get();
        if(count($orders) > 1)
        {
            $orders->each(function ($order) {
                $d1 = $order->created_at;
                $d2 = Carbon::parse($order->dispatch_at);
                $order->day_dif = $d2->diffInDays($d1);
            });
            $sum = $orders->sum('day_dif');
            $count =$sum/count($orders);
            $day = $count == 1 ? 'day' : 'days';
            if($count > 7)
            {
                $return = (object)['lable'=>"Usually dispatches within More than 7 ".$day , 'day'=>7];
            }
            else{
                $return = (object)['lable'=>'Usually dispatches within '.$count.' '.$day , 'day'=>(int)$count];
            }
        }

        return $return;

    }
    public function getReferalTypeAttribute()
    {
        if($this->store)
        {
            return $this->store->referal_type;
        }
        return 'others' ;
    }
    public function getDefaultWalletAttribute()
    {
        if($this->wallets)
        {
            return $this->wallets->where('type','normal')->where('active',1)->first();
        }
        return null;
    }
    public function getOldWalletAttribute()
    {
        if($this->wallets)
        {
            return $this->wallets->where('type','normal')->where('active',0)->first();
        }
        return null;
    }
}
