<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function detail($id)
    {
        $item = Transaction::find($id);
        return view('admin.transaction.detail',get_defined_vars());
    }
}
