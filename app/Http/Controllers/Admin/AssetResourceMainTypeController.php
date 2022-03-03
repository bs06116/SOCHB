<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssetResourceMainType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;



class AssetResourceMainTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title =  'Location';
        if ($request->ajax()) {
            $_order = request('order');
            $_columns = request('columns');
            $order_by = $_columns[$_order[0]['column']]['name'];
            $order_dir = $_order[0]['dir'];
            $search = request('search');
            $skip = request('start');
            $take = request('length');
            $search = request('search');
            $query = AssetResourceMainType::query();
            $query->orderBy('app_res_cat_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("res_cat_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->res_cat_enabled =   $d->res_cat_enabled == 'Y'? "Yes":"No";

                $d->action = '
                <form method="POST" action="' . route('assetresourcemaintype.destroy', $d->app_res_cat_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('assetresourcemaintype.edit', $d->app_res_cat_id) . '">
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
        return view('asset_resource_main_type.index');
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
            'res_cat_code' => 'required|unique:tbl_app_resource_category,res_cat_code|max:15',
         ]);

         AssetResourceMainType::create([
            'res_cat_code' => strtoupper($request->res_cat_code),
            'res_cat_desc' => $request->res_cat_desc,
            'res_cat_enabled' => $request->res_cat_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('Asset Resource Main Type
        created successfully!')->success();
        return redirect()->route('assetresourcemaintype.index');
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
    public function edit(AssetResourceMainType $assetresourcemaintype)
    {
        return view('asset_resource_main_type.edit', compact('assetresourcemaintype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetResourceMainType $assetresourcemaintype)
    {
        $request->validate([
            'res_cat_code' => 'required|unique:tbl_app_resource_category,res_cat_code,' . $assetresourcemaintype->app_res_cat_id . ',app_res_cat_id|max:15',
        ]);

        $assetresourcemaintype->update([
            'res_cat_code' => strtoupper($request->res_cat_code),
            'res_cat_desc' => $request->res_cat_desc,
            'res_cat_enabled' => $request->res_cat_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Asset Resource Main Type
         updated successfully!')->success();
        return redirect()->route('assetresourcemaintype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetResourceMainType $assetresourcemaintype)
    {
        $assetresourcemaintype->delete();
        flash('Asset Resource Main
          Type deleted successfully!')->info();
        return back();
    }
}
