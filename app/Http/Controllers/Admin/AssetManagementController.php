<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssetManagement;
use App\Company;
use App\Location;
use App\AssetCategoryDetail;
use App\ApplicationResourceCategory;
use App\AssetApplication;
use App\SIEM;
use App\AssetSiem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use App\SIEMDataProcess;
use Carbon\Carbon;



class AssetManagementController extends Controller
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
            $query = AssetManagement::query()->join('tbl_company', 'tbl_company.company_id', "=", "tbl_asset.company_id")
            ->join('tbl_location', 'tbl_location.location_id', "=", "tbl_asset.location_id")
            ->join('tbl_asset_category_detail', 'tbl_asset_category_detail.asset_cat_detail_id', "=", "tbl_asset.asset_cat_detail_id")
            ->join('tbl_app_resource_sub_cat', 'tbl_app_resource_sub_cat.app_res_sub_cat_id', "=", "tbl_asset.app_res_sub_cat_id")
            ->join('tbl_asset_application', 'tbl_asset_application.asset_app_id', "=", "tbl_asset.asset_app_id");

            $query->orderBy('asset_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("asset_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $reffernce = [];
                $result = AssetSiem::select('tbl_asset_siem_link.siem_reference','tbl_siem.siem_code')->join('tbl_siem', 'tbl_asset_siem_link.siem_id', '=', 'tbl_siem.siem_id')
                            ->where('tbl_asset_siem_link.asset_id',$d->asset_id)->get()->toArray();
                foreach($result as $r):
                    $reffernce[] = $r['siem_code'].'=>'.$r['siem_reference'];
                endforeach;
                $d->asset_id = $d->asset_id;
                $d->company_code =  $d->company_code;
                $d->location_code =  $d->location_code;
                $d->cat_detail_code =  $d->cat_detail_code;
                $d->sub_cat_code =  $d->sub_cat_code;
                $d->asset_app_code =  $d->asset_app_code;
                $d->asset_enabled =   $d->asset_enabled == 'Y'? "Yes":"No";
                $d->siem_reffernce = $reffernce;
                $d->action = '
                <form method="POST" action="' . route('assetmanagement.destroy', $d->asset_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('assetmanagement.edit', $d->asset_id) . '">
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
        if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $company = $companies->select('tbl_company.company_code','tbl_company.company_id')->get();
        }else{
            $company = Company::select('company_code', 'company_id')->get();
        }
        $location = Location::pluck('location_code', 'location_id');
        $asetcategorydetail = AssetCategoryDetail::pluck('cat_detail_code', 'asset_cat_detail_id');
        $applicationresourcecategory = ApplicationResourceCategory::pluck('sub_cat_code', 'app_res_sub_cat_id');
        $assetapplication = AssetApplication::pluck('asset_app_code', 'asset_app_id');
        $siem = SIEM::pluck('siem_code', 'siem_id');
        return view('asset_management.index',compact('company','location','asetcategorydetail','applicationresourcecategory','assetapplication','siem'));
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
            'asset_code' => 'required|unique:tbl_asset,asset_code|max:15',
            'ip_address' => 'max:50',
            'host_name' => 'max:50',
            'domain_name' => 'max:50',
            'asset_desc' => 'max:50',
         ]);
        $asset_last_id = AssetManagement::insertGetId([
            'asset_code' => strtoupper($request->asset_code),
            'ip_address' => $request->ip_address,
            'host_name' => $request->host_name,
            'domain_name' => $request->domain_name,
            'asset_desc' => $request->asset_desc,
            'company_id' => $request->company_id,
            'location_id' => $request->location_id,
            'asset_cat_detail_id' => $request->asset_cat_detail_id,
            'app_res_sub_cat_id' => $request->app_res_sub_cat_id,
            'asset_app_id' => $request->asset_app_id,
            'asset_enabled' => $request->asset_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()
        ]);
        $siem = $request->siem;
        $ref = $request->ref;
        $data = array();
        for( $i = 0; $i<count($siem); $i++){
            $data [] = array('asset_id'=>$asset_last_id,'siem_id'=>$siem[$i], 'siem_reference'=>$ref[$i],'user_name'=>Auth::user()->username, 'time_stamp'=>Carbon::now());
        }
        if(count($data)>0){
            AssetSiem::insert($data);
        }
        flash('Asset management created successfully!')->success();
        return redirect()->route('assetmanagement.index');
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
    public function edit(AssetManagement $assetmanagement)
    {
        if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $company = $companies->select('tbl_company.company_code','tbl_company.company_id')->get();
        }else{
            $company = Company::select('company_code', 'company_id')->get();
        }
        $location = Location::pluck('location_code', 'location_id');
        $asetcategorydetail = AssetCategoryDetail::pluck('cat_detail_code', 'asset_cat_detail_id');
        $applicationresourcecategory = ApplicationResourceCategory::pluck('sub_cat_code', 'app_res_sub_cat_id');
        $assetapplication = AssetApplication::pluck('asset_app_code', 'asset_app_id');
        return view('asset_management.edit',compact('assetmanagement','company','location','asetcategorydetail','applicationresourcecategory','assetapplication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetManagement $assetmanagement)
    {
        $request->validate([
            'asset_code' => 'required|unique:tbl_asset,asset_code,' . $assetmanagement->asset_id . ',asset_id|max:15',
             'ip_address' => 'max:50',
            'host_name' => 'max:50',
            'domain_name' => 'max:50',
            'asset_desc' => 'max:50',
        ]);

        $assetmanagement->update([
            'asset_code' => strtoupper($request->asset_code),
            'ip_address' => $request->ip_address,
            'host_name' => $request->host_name,
            'domain_name' => $request->domain_name,
            'asset_desc' => $request->asset_desc,
            'company_id' => $request->company_id,
            'location_id' => $request->location_id,
            'asset_cat_detail_id' => $request->asset_cat_detail_id,
            'app_res_sub_cat_id' => $request->app_res_sub_cat_id,
            'asset_app_id' => $request->asset_app_id,
            'asset_enabled' => $request->asset_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        $siem = $request->siem;
        $ref = $request->ref;
        $data = array();
        for( $i = 0; $i<count($siem); $i++){
            $data [] = array('asset_id'=>$assetmanagement->asset_id,'siem_id'=>$siem[$i], 'siem_reference'=>$ref[$i],
            'last_user_name'=>Auth::user()->username,
            'last_time_stamp'=>Carbon::now());
        }
        if(count($data)>0){
            AssetSiem::where('asset_id',$assetmanagement->asset_id)->delete();
            AssetSiem::insert($data);
        }
        flash('Asset management updated successfully!')->success();
        return redirect()->route('assetmanagement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetManagement $assetmanagement)
    {
        $assetmanagement->delete('cascade');
        AssetSiem::where('asset_id',$assetmanagement->asset_id)->delete();
        flash('Asset Management deleted successfully!')->info();
        return back();
    }
    public function loadSIEM(Request $request)
    {
        $company_id  = $request->company_id ;
        $result = SIEM::where('company_id', $company_id )->get();
        return response()->json(['result' => $result]);
    }
    public function loadLocation(Request $request)
    {
        $company_id  = $request->company_id ;
        $result = Location::where('company_id', $company_id )->get();
        return response()->json(['result' => $result]);
    }


    // {
    //     $assetmanagement->delete('cascade');
    //     flash('Asset Management deleted successfully!')->info();
    //     return back();
    // }

}
