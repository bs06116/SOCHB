<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssetCategorySubType;
use App\AssetCategoryMainType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;



class AssetCategorySubTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-asset-category-sub-type');
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-asset-category-sub-type', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-asset-category-sub-type', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!auth()->user()->can("delete-asset-category-sub-type")){
                $classDelete = 'd-none';
            }else{
                $classDelete = '';
            }
            if(!auth()->user()->can("edit-asset-category-sub-type")){
                $classEdit = 'd-none';
            }else{
                $classEdit = '';
            }
            $_order = request('order');
            $_columns = request('columns');
            $order_by = $_columns[$_order[0]['column']]['name'];
            $order_dir = $_order[0]['dir'];
            $search = request('search');
            $skip = request('start');
            $take = request('length');
            $search = request('search');
            $query = AssetCategorySubType::query();
            $query->orderBy('asset_main_cat_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("sub_cat_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->sub_cat_enabled =   $d->sub_cat_enabled == 'Y'? "Yes":"No";

                $d->action = '
                <form method="POST" action="' . route('assetcategorysubtype.destroy', $d->asset_sub_cat_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1 '.$classEdit.'" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('assetcategorysubtype.edit', $d->asset_sub_cat_id) . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button type="submit" class="btn delete btn-danger btn-sm m-1 '.$classDelete.'" data-toggle="tooltip" data-placement="top" title="Delete company" href="javascript:void()">
            <i class="fas fa-trash"></i>
        </button> </form>';
            }
            return [
                "draw" => request('draw'),
                "recordsTotal" => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                "data" => $data,
            ];
        }
        $assetcategorymaintype = AssetCategoryMainType::pluck('main_cat_code', 'asset_main_cat_id');

        return view('assets_category_sub_type.index',compact('assetcategorymaintype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'sub_cat_code' => 'required|unique:tbl_asset_sub_category,sub_cat_code|max:15',
         ]);
         AssetCategorySubType::create([
            'asset_main_cat_id' => $request->asset_main_cat_id,
            'sub_cat_code' => strtoupper($request->sub_cat_code),
            'sub_cat_desc' => $request->sub_cat_desc,
            'sub_cat_enabled' => $request->sub_cat_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('Asset Category Sub Type created successfully!')->success();
        return redirect()->route('assetcategorysubtype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetCategorySubType $assetcategorysubtype)
    {
        $title =  'Update Location Type';
        $assetcategorymaintype = AssetCategoryMainType::pluck('main_cat_code', 'asset_main_cat_id');

        return view('assets_category_sub_type.edit', compact('assetcategorysubtype', 'assetcategorymaintype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetCategorySubType $assetcategorysubtype)
    {
        $request->validate([
            'sub_cat_code' => 'required|unique:tbl_asset_main_category,main_cat_code,' . $assetcategorysubtype->asset_sub_cat_id . ',asset_main_cat_id|max:15',
        ]);

        $assetcategorysubtype->update([
            'sub_cat_code' => strtoupper($request->sub_cat_code),
            'sub_cat_desc' => $request->sub_cat_desc,
            'sub_cat_enabled' => $request->sub_cat_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Asset Category Sub Type updated successfully!')->success();
        return redirect()->route('assetcategorysubtype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategorySubType $assetcategorysubtype)
    {
        $assetcategorysubtype->delete();
        flash('Asset Category Sub Type deleted successfully!')->info();
        return back();
    }
}
