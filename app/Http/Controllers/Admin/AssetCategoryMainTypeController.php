<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssetCategoryMainType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;



class AssetCategoryMainTypeController extends Controller
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
            $query = AssetCategoryMainType::query();
            $query->orderBy('asset_main_cat_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("main_cat_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->action = '
                <form method="POST" action="' . route('assetcategorymaintype.destroy', $d->asset_main_cat_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('assetcategorymaintype.edit', $d->asset_main_cat_id) . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete company" href="javascript:void()">
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
        return view('assets_category_main_type.index');
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
            'main_cat_code' => 'required|unique:tbl_asset_main_category,main_cat_code|max:255',
         ]);

         AssetCategoryMainType::create([
            'main_cat_code' => $request->main_cat_code,
            'main_cat_desc' => $request->main_cat_desc,
            'main_cat_enabled' => $request->main_cat_enabled,
            'time_stamp' => Carbon::now()

        ]);
        flash('Asset Category Main Type created successfully!')->success();
        return redirect()->route('assetcategorymaintype.index');
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
    public function edit(AssetCategoryMainType $assetcategorymaintype)
    {
        $title =  'Update Location Type';
        return view('assets_category_main_type.edit', compact('assetcategorymaintype', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetCategoryMainType $assetcategorymaintype)
    {
        $request->validate([
            'main_cat_code' => 'required|unique:tbl_asset_main_category,main_cat_code,' . $assetcategorymaintype->location_tasset_main_cat_idype_id . ',asset_main_cat_id|max:255',
        ]);

        $assetcategorymaintype->update([
            'main_cat_code' => $request->main_cat_code,
            'main_cat_desc' => $request->main_cat_desc,
            'main_cat_enabled' => $request->main_cat_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Asset Category Main Type updated successfully!')->success();
        return redirect()->route('assetcategorymaintype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategoryMainType $assetcategorymaintype)
    {
        $assetcategorymaintype->delete();
        flash('Asset Category Main Type deleted successfully!')->info();
        return back();
    }
}
