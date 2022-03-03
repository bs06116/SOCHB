<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ApplicationResourceCategory;
use App\AssetResourceMainType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;



class ApplicationResourceCategoryController extends Controller
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
            $query = ApplicationResourceCategory::query()->join('tbl_app_resource_category', 'tbl_app_resource_category.app_res_cat_id', "=", "tbl_app_resource_sub_cat.app_res_cat_id");
            $query->orderBy('app_res_sub_cat_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("sub_cat_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->res_cat_code = $d->res_cat_code;
                $d->sub_cat_enabled =   $d->sub_cat_enabled == 'Y'? "Yes":"No";
                $d->action = '
                <form method="POST" action="' . route('applicationresourcecategory.destroy', $d->app_res_sub_cat_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('applicationresourcecategory.edit', $d->app_res_sub_cat_id) . '">
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
        $assetresourcemaintype = AssetResourceMainType::pluck('res_cat_code', 'app_res_cat_id');

        return view('application_resource_category.index',compact('assetresourcemaintype'));
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
         ApplicationResourceCategory::create([
            'app_res_cat_id' => $request->app_res_cat_id,
            'sub_cat_code' => strtoupper($request->sub_cat_code),
            'sub_cat_desc' => $request->sub_cat_desc,
            'sub_cat_enabled' => $request->sub_cat_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('Asset Category Sub Type created successfully!')->success();
        return redirect()->route('applicationresourcecategory.index');
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
    public function edit(ApplicationResourceCategory $applicationresourcecategory)
    {
        $assetresourcemaintype = AssetResourceMainType::pluck('res_cat_code', 'app_res_cat_id');

        return view('application_resource_category.edit', compact('applicationresourcecategory', 'assetresourcemaintype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationResourceCategory $applicationresourcecategory)
    {
        $request->validate([
            'sub_cat_code' => 'required|unique:tbl_asset_main_category,main_cat_code,' . $applicationresourcecategory->asset_sub_cat_id . ',asset_main_cat_id|max:15',
        ]);

        $applicationresourcecategory->update([
            'sub_cat_code' =>strtoupper( $request->sub_cat_code),
            'sub_cat_desc' => $request->sub_cat_desc,
            'sub_cat_enabled' => $request->sub_cat_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Asset Category Sub Type updated successfully!')->success();
        return redirect()->route('applicationresourcecategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationResourceCategory $applicationresourcecategory)
    {
        $applicationresourcecategory->delete();
        flash('Asset Category Sub Type deleted successfully!')->info();
        return back();
    }
}
