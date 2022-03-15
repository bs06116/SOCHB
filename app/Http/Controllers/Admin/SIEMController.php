<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Company;
use App\Location;
use App\SIEMType;
use App\SIEM;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;
use Auth;



class SIEMController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-siem');
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-siem', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-siem', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title =  'Location';
        if ($request->ajax()) {
            if(!auth()->user()->can("delete-siem")){
                $classDelete = 'd-none';
            }else{
                $classDelete = '';
            }
            if(!auth()->user()->can("edit-siem")){
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
            $query = SIEM::query()->join('tbl_company', 'tbl_company.company_id', "=", "tbl_siem.company_id")
            ->join('tbl_location', 'tbl_location.location_id', "=", "tbl_siem.location_id")
            ->join('tbl_siem_type', 'tbl_siem_type.siem_type_id', "=", "tbl_siem.siem_type_id");
            $query->orderBy('siem_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("siem_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as &$d) {
                $d->company_txt =  $d->company_code;
                $d->location_txt =  $d->location_code;
                $d->siem_type_txt =  $d->siem_type_code;
                $d->siem_enabled =   $d->siem_enabled == 'Y'? "Yes":"No";


                $d->action = '
                <form method="POST" action="' . route('siem.destroy', $d->siem_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1 '.$classEdit.'" data-toggle="tooltip" data-placement="top" title="Edit siem details" href="' . route('siem.edit', $d->siem_id) . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button type="submit" class="btn delete btn-danger btn-sm m-1 '.$classDelete.'" data-toggle="tooltip" data-placement="top" title="Delete SEI<" href="javascript:void()">
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
            $companies = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $companies = Company::pluck('company_code', 'company_id');
        }
        $location = Location::pluck('location_code', 'location_id');
        $siemType = SIEMType::pluck('siem_type_code', 'siem_type_id');
        return view('siem.index',compact('companies','location','siemType'));
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
            'siem_code' => 'required|unique:tbl_siem,siem_code|max:15',
            'siem_desc' => 'max:50',
         ]);

         SIEM::create([
            'company_id' => $request->company_id,
            'location_id' => $request->location_id,
            'siem_type_id' => $request->siem_type_id,
            'siem_code' => strtoupper($request->siem_code),
            'siem_desc' => $request->siem_desc,
            'siem_enabled' => $request->siem_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('SEIM created successfully!')->success();
        return redirect()->route('siem.index');
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
    public function edit(SIEM $siem)
    {
        if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $companies = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $companies = Company::pluck('company_code', 'company_id');
        }
        $location = Location::pluck('location_code', 'id');
        $siemType = SIEMType::pluck('siem_type_code', 'siem_type_id');
        return view('siem.edit',compact('siem','companies','location','siemType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SIEM $siem)
    {
        $request->validate([
            'siem_code' => 'required|unique:tbl_siem,siem_code,' . $siem->siem_id . ',siem_id|max:15',
            'siem_desc' => 'max:50',

        ]);

        $siem->update([
            'company_id' => $request->company_id,
            'location_id' => $request->location_id,
            'siem_type_id' => $request->siem_type_id,
            'siem_code' => strtoupper($request->siem_code),
            'siem_desc' => $request->siem_desc,
            'siem_enabled' => $request->siem_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('SIEM updated successfully!')->success();
        return redirect()->route('siem.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SIEM $siem)
    {
        $siem->delete();
        flash('SIEM deleted successfully!')->info();
        return back();
    }
}
