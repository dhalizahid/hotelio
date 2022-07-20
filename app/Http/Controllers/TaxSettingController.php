<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
// use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Models\TaxSetting;
use Exception;
use Yajra\DataTables\DataTables as DataTables;

class TaxSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $TaxSettings = TaxSetting::all();
        // return view('taxSetting.index',compact('TaxSettings'));
        if (request()->ajax()) 
        {
            return $TaxSetting = DataTables::of(TaxSetting::all())->make(true);
        }
        return view('taxSetting.index');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taxSetting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $TaxSettings = TaxSetting::create($request->all());
            return "Tax Added SuccessFully !";
        } catch (Exception $error) {
            $error->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TaxSetting::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $TaxSetting = TaxSetting::find($id);
        return view('taxSetting.edit',compact('TaxSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        TaxSetting::find($id)->update($request->all());
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaxSetting::find($id)->delete();
        return back()->with('Destroy', 'Delete Completed !');
    }
    public function destroyAll()
    {
        TaxSetting::withTrashed()->delete();
        return back()->with('DestroyAll', 'সমস্ত ডাটাকে খালি করা হলো');
    }
    public function trash()
    {
        $TaxSettings = TaxSetting::onlyTrashed()->get();
        return view('taxSetting.trash',compact('TaxSettings'));
    }
    public function restore($id)
    {
        TaxSetting::withTrashed()->where('id',$id)->restore();
        return back()->with('Restore', 'Restore SuccessFully !');
    }
    public function restoreAll()
    {
        TaxSetting::withTrashed()->restore();
        return back()->with('RestoreAll', 'সমস্ত ডাটাকে পুনরুদ্ধার করা হয়েছে');
    }
    public function forceDeleted($id)
    {
        TaxSetting::withTrashed()->where('id',$id)->forceDelete();
        return back()->with('PermanentlyDelete', 'Permanently Delete Completed !');
    }
    public function emptyTrash()
    {
        TaxSetting::onlyTrashed()->forceDelete();
        return back()->with('EmptyTrash', 'ট্রাস সম্পূর্ণরূপে খালি করা হলো');
    }
}
