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



class LocationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-location-type');
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-location-type', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-location-type', ['only' => ['destroy']]);
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
            if(!auth()->user()->can("delete-location-type")){
                $classDelete = 'd-none';
            }else{
                $classDelete = '';
            }
            if(!auth()->user()->can("edit-location-type")){
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
            $query = LocationType::query();
            $query->orderBy('location_type_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("loc_type_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->location_type_id =  $d->location_type_id;
                $d->loc_type_enabled =   $d->loc_type_enabled == 'Y'? "Yes":"No";

                $d->action = '
                <form method="POST" action="' . route('locationstype.destroy', $d->location_type_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1 '.$classEdit.'" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('locationstype.edit', $d->location_type_id) . '">
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
        return view('location_type.index');
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
            'loc_type_code' => 'required|unique:tbl_location_type,loc_type_code|max:15',
            'loc_type_desc' => 'max:50',
         ]);

              LocationType::create([
            'loc_type_code' => strtoupper($request->loc_type_code),
            'loc_type_desc' => $request->loc_type_desc,
            'loc_type_enabled' => $request->loc_type_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()

        ]);
        flash('Locataion created successfully!')->success();
        return redirect()->route('locationstype.index');
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
    public function edit(LocationType $locationstype)
    {
        $title =  'Update Location Type';
        return view('location_type.edit', compact('locationstype', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationType $locationstype)
    {
        $request->validate([
            'loc_type_code' => 'required|unique:tbl_location_type,loc_type_code,' . $locationstype->location_type_id . ',location_type_id|max:15',
            'loc_type_desc' => 'max:50',

        ]);

        $locationstype->update([
            'loc_type_code' => strtoupper($request->loc_type_code),
            'loc_type_desc' => $request->loc_type_desc,
            'loc_type_enabled' => $request->loc_type_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('Location type updated successfully!')->success();
        return redirect()->route('locationstype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationType $locationstype)
    {
        $locationstype->delete();
        flash('Location Type deleted successfully!')->info();
        return back();
    }
}
