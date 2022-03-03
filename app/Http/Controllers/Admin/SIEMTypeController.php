<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SIEMType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use Carbon\Carbon;


class SIEMTypeController extends Controller
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
            $query = SIEMType::query();
            $query->orderBy('siem_type_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("siem_type_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as $index=>&$d) {
                $d->siem_type_enabled =   $d->siem_type_enabled == 'Y'? "Yes":"No";

                $d->action = '
                <form method="POST" action="' . route('siemtype.destroy', $d->siem_type_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('siemtype.edit', $d->siem_type_id) . '">
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
        return view('siem_type.index');
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
            'siem_type_code' => 'required|unique:tbl_siem_type,siem_type_code|max:15',
            'siem_type_desc' => 'max:50',
         ]);
        SIEMType::create([
            'siem_type_code' => strtoupper($request->siem_type_code),
            'siem_type_desc' => $request->siem_type_desc,
            'siem_type_enabled' => $request->siem_type_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()
        ]);
        flash('SIEM Type created successfully!')->success();
        return redirect()->route('siem_type.index');
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
    public function edit(SIEMType $siemtype)
    {
        return view('siem_type.edit', compact('siemtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SIEMType $siemtype)
    {
        $request->validate([
            'siem_type_code' => 'required|unique:tbl_siem_type,siem_type_code,' . $siemtype->id . ',siem_type_id|max:15',
            'siem_type_desc' => 'max:50',
        ]);

        $siemtype->update([
            'siem_type_code' => strtoupper($request->siem_type_code),
            'siem_type_desc' => $request->siem_type_desc,
            'siem_type_enabled' => $request->siem_type_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        flash('SIEM type updated successfully!')->success();
        return redirect()->route('siem_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SIEMType $siemtype)
    {
        $siemtype->delete();
        flash('SIEMType Type deleted successfully!')->info();
        return back();
    }
}
