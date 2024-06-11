<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\AnnouncementDataTable;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Annoucement');
    }
    public function index(AnnouncementDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.announcement.index', get_defined_vars());
    }
    public function view(Request $request)
    {
        $item = "";  
        if($request->id)
        {
            $item = Announcement::find($request->id);
        }
        return view('admin.announcement.view',get_defined_vars());
    }
    public function save(Request $request)
    {
        $request->validate([
            'label'=>'required',
            'text'=>'required',
            'start_from'=>'required',
            'end_on'=>'required',
            'background'=>'required'
        ]);
        if($request->type == "timer")
        {
            $datee = Carbon::parse($request->end_on);
            $newDatee = $datee->addDays(1);
            $request->merge(['timer' =>$newDatee->toDateString()]);
        }
        $query = ['id'=>$request->id];
        Announcement::updateOrInsert($query , $request->except('_token'));
        $msg = $request->id ? 'Annoumcement updated Successfully!' : 'Annoumcement Created Successfully!'; 
        return redirect()->route('admin.announcement.index')->with('message',$msg);    
    }
    public function delete($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->back()->with('message','Anouncement Delete Successfully!');    
    }
}
