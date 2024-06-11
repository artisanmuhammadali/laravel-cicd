<?php

namespace App\Http\Controllers\Admin;
use App\DataTables\Admin\DisputeUserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;
use App\Models\User;

class DisputeUserController extends Controller
{
    public function list(DisputeUserDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.disputeUsers.list', get_defined_vars());
    }
    public function updateUserStatus(Request $request)
    {
        User::find($request->id)->update(['status'=>$request->status]);
        return response()->json(true);
    }
    public function modal(Request $request)
    {
        $user = User::find($request->id);
        $html = view('admin.disputeUsers.manage-user',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
}
