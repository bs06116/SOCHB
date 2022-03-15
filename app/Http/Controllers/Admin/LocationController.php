<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Company;
use App\Location;
use App\LocationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;
use DB;


class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-location');
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-location', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-location', ['only' => ['destroy']]);
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
            if(!auth()->user()->can("delete-location")){
                $classDelete = 'd-none';
            }else{
                $classDelete = '';
            }
            if(!auth()->user()->can("edit-location")){
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
            $query = Location::query()->join('tbl_company', 'tbl_company.company_id', "=", "tbl_location.company_id");
                $query->when(Auth::id() !=1, function ($q) {
                $q->join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
                    $q->where('tbl_user_company.user_id',Auth::id());
            });
            $query->join('tbl_location_type', 'tbl_location_type.location_type_id', "=", "tbl_location.location_type_id");
            $query->orderBy('location_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("location_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();

            foreach ($data as &$d) {
                $d->location_id = $d->location_id;
                $d->company_txt =  $d->company_code;
                $d->location_type_txt =  $d->loc_type_code;
                $d->location_enabled =   $d->location_enabled == 'Y'? "Yes":"No";
                $d->action = '
                <form method="POST" action="' . route('locations.destroy', $d->location_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1 '.$classEdit.'" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('locations.edit', $d->location_id) . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button type="submit" class="btn delete btn-danger btn-sm m-1 '.$classDelete.' " data-toggle="tooltip" data-placement="top" title="Delete company" href="javascript:void()">
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
      //  $companies = Company::pluck('company_code', 'company_id');
      if(Auth::id() !=1){
            $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
            $companies->where('tbl_user_company.user_id',Auth::id());
            $companies = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $companies = Company::pluck('company_code', 'company_id');
        }
      $locationType = LocationType::pluck('loc_type_code', 'location_type_id');
      return view('location.index', compact('companies', 'locationType'));
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
            'location_code' => 'required|unique:tbl_location,location_code|max:15',
            'location_desc' => 'max:50',
        ]);

        Location::create([
            'location_code' =>strtoupper($request->location_code),
            'location_desc' => $request->location_desc,
            'location_enabled' => $request->location_enabled,
            'company_id' => $request->company_id,
            'location_type_id' => $request->location_type_id,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()


        ]);
        flash('Locataion created successfully!')->success();
        return redirect()->route('locations.index');
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
    public function edit(Location $location)
    {
        $title =  'Update Location';
       // $companies = Company::pluck('company_code', 'company_id');
       if(Auth::id() !=1){
        $companies = Company::join('tbl_user_company', 'tbl_company.company_id', '=', 'tbl_user_company.company_id');
        $companies->where('tbl_user_company.user_id',Auth::id());
        $companies = $companies->pluck('tbl_company.company_code','tbl_company.company_id');
        }else{
            $companies = Company::pluck('company_code', 'company_id');
        }
        $locationType = LocationType::pluck('loc_type_code', 'location_type_id');
        return view('location.edit', compact('location', 'title', 'companies', 'locationType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'location_code' => 'required|unique:tbl_location,location_code,' . $location->location_id . ',location_id|max:15',
            'location_desc' => 'max:50',

        ]);

        $location->update([
            'location_code' => strtoupper($request->location_code),
            'location_desc' => $request->location_desc,
            'location_enabled' => $request->location_enabled,
            'company_id' => $request->company_id,
            'location_type_id' => $request->location_type_id,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Location updated successfully!')->success();
        return redirect()->route('locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
        flash('Location deleted successfully!')->info();
        return back();
    }
}
