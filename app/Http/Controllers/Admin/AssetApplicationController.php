<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\AssetApplication;
use App\Company;
use App\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;

class AssetApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-asset-application');
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-asset-application', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-asset-application', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!auth()->user()->can("delete-asset-application")){
                $classDelete = 'd-none';
            }else{
                $classDelete = '';
            }
            if(!auth()->user()->can("edit-asset-application")){
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
            $query = AssetApplication::query()->join('tbl_principal', 'tbl_principal.principal_id', "=", "tbl_asset_application.principal_id")
            ->join('tbl_company', 'tbl_company.company_id', "=", "tbl_asset_application.company_id");
            $query->when(Auth::id() !=1, function ($q) {
                $q->join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
                    $q->where('tbl_user_company.user_id',Auth::id());
            });
            $query->orderBy('asset_app_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("asset_app_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->principal_code =   $d->principal_code;
                $d->company_code =   $d->company_code;
                $d->asset_app_enabled =   $d->asset_app_enabled == 'Y'? "Yes":"No";
                $d->action = '
                <form method="POST" action="' . route('assetapplication.destroy', $d->asset_app_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1 '.$classEdit.'" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('assetapplication.edit', $d->asset_app_id) . '">
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
        if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $company = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $company = Company::pluck('company_code', 'company_id');
        }
        $vendor = Vendors::pluck('principal_code', 'principal_id');
        return view('asset_application.index',compact('company','vendor'));
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
            'asset_app_code' => 'required|unique:tbl_asset_application,asset_app_code|max:15',
            'asset_app_desc' => 'max:50'
         ]);

         AssetApplication::create([
            'company_id' => $request->company_id,
            'principal_id' => $request->principal_id,
            'asset_app_code' => strtoupper($request->asset_app_code),
            'asset_app_desc' => $request->asset_app_desc,
            'asset_app_enabled' => $request->asset_app_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('Asset application created successfully!')->success();
        return redirect()->route('assetapplication.index');
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
    public function edit(AssetApplication $assetapplication)
    {
        if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $company = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $company = Company::pluck('company_code', 'company_id');
        }
         $vendor = Vendors::pluck('principal_code', 'principal_id');
        return view('asset_application.edit',compact('assetapplication','company','vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetApplication $assetapplication)
    {
        $request->validate([
            'asset_app_code' => 'required|unique:tbl_asset_application,asset_app_code,' . $assetapplication->asset_app_id . ',asset_app_id|max:15',
            'asset_app_desc' => 'max:50'
        ]);

        $assetapplication->update([
            'company_id' => $request->company_id,
            'principal_id' => $request->principal_id,
            'asset_app_code' => strtoupper($request->asset_app_code),
            'asset_app_desc' => $request->asset_app_desc,
            'asset_app_enabled' => $request->asset_app_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Asset applciation updated successfully!')->success();
        return redirect()->route('assetapplication.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetApplication $assetapplication)
    {
        $assetapplication->delete();
        flash('Asset Applciatione deleted successfully!')->info();
        return back();
    }
}
