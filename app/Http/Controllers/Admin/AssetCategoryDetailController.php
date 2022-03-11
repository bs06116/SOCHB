<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\AssetCategoryDetail;
use App\Vendors;
use App\AssetCategoryMainType;
use App\AssetCategorySubType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;
use Auth;



class AssetCategoryDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $_order = request('order');
            $_columns = request('columns');
            $order_by = $_columns[$_order[0]['column']]['name'];
            $order_dir = $_order[0]['dir'];
            $search = request('search');
            $skip = request('start');
            $take = request('length');
            $search = request('search');
            $query = AssetCategoryDetail::query()->join('tbl_vendor', 'tbl_vendor.vendor_id', "=", "tbl_asset_category_detail.vendor_id")
            ->leftjoin('tbl_asset_main_category', 'tbl_asset_main_category.asset_main_cat_id', "=", "tbl_asset_category_detail.asset_sub_main_id")
            ->leftjoin('tbl_asset_sub_category', 'tbl_asset_sub_category.asset_sub_cat_id', "=", "tbl_asset_category_detail.asset_sub_cat_id");
            $query->orderBy('asset_cat_detail_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("cat_detail_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as &$d) {
                $d->vendor_code_txt = $d->vendor_code;
                $d->main_cat_txt =  $d->main_cat_code;
                $d->sub_cat_text =  $d->sub_cat_code;
                $d->cat_detail_enabled =   $d->cat_detail_enabled == 'Y'? "Yes":"No";
                $d->action = '
                <form method="POST" action="' . route('assetcategorydetail.destroy', $d->asset_cat_detail_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit siem details" href="' . route('assetcategorydetail.edit', $d->asset_cat_detail_id) . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete SEI<" href="javascript:void()">
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
        $vendors = Vendors::pluck('vendor_code', 'vendor_id');
        $assetcategorymaintype = AssetCategoryMainType::select('main_cat_code', 'asset_main_cat_id')->get();
        $assetcategorysubtype = AssetCategorySubType::pluck('sub_cat_code', 'asset_sub_cat_id');
        return view('assets_category_details.index',compact('vendors','assetcategorymaintype','assetcategorysubtype'));
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
            'cat_detail_code' => 'required|unique:tbl_asset_category_detail,cat_detail_code|max:15',
         ]);

         AssetCategoryDetail::create([
            'vendor_id' => $request->vendor_id,
            'asset_sub_main_id' => $request->asset_sub_main_id,
            'asset_sub_cat_id' => $request->asset_sub_cat_id,
            'cat_detail_code' => strtoupper($request->cat_detail_code),
            'cat_detail_desc' => $request->cat_detail_desc,
            'cat_detail_enabled' => $request->cat_detail_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()
        ]);
        flash('AssetCategoryDetail created successfully!')->success();
        return redirect()->route('assetcategorydetail.index');
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
    public function edit(AssetCategoryDetail $assetcategorydetail)
    {
        $vendors = Vendors::pluck('vendor_code', 'vendor_id');
        $assetcategorymaintype = AssetCategoryMainType::select('main_cat_code', 'asset_main_cat_id')->get();
        $assetcategorysubtype = AssetCategorySubType::pluck('sub_cat_code', 'asset_sub_cat_id');
        return view('assets_category_details.edit',compact('assetcategorydetail','vendors','assetcategorymaintype','assetcategorysubtype'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetCategoryDetail $assetcategorydetail)
    {
        $request->validate([
            'cat_detail_code' => 'required|unique:tbl_asset_category_detail,cat_detail_code,' . $assetcategorydetail->asset_cat_detail_id . ',asset_cat_detail_id|max:15',
        ]);
        $assetcategorydetail->update([
            'vendor_id' => $request->vendor_id,
            'asset_sub_main_id' => $request->asset_sub_main_id,
            'asset_sub_cat_id' => $request->asset_sub_cat_id,
            'cat_detail_code' => $request->cat_detail_code,
            'cat_detail_desc' => $request->cat_detail_desc,
            'cat_detail_enabled' => $request->cat_detail_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('AssetCategoryDetail updated successfully!')->success();
        return redirect()->route('assetcategorydetail.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategoryDetail $assetcategorydetail)
    {
        $assetcategorydetail->delete();
        flash('AssetCategoryDetail deleted successfully!')->info();
        return back();
    }
    public function loadSubType(Request $request)
    {
        $category_id = $request->category_id;
        $result = AssetCategorySubType::where('asset_main_cat_id', $category_id)->get();
        return response()->json(['result' => $result]);
    }
}
