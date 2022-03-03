<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CompanyStoreRequest;
use App\User;
use Carbon\Carbon;
use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title =  'Company';
        if ($request->ajax()) {
            $_order = request('order');
            $_columns = request('columns');
            $order_by = $_columns[$_order[0]['column']]['name'];
            $order_dir = $_order[0]['dir'];
            $search = request('search');
            $skip = request('start');
            $take = request('length');
            $search = request('search');
            $query = Company::query();
            $query->orderBy('company_id', 'DESC')->get();
            $recordsTotal = $query->count();
            if (isset($search['value'])) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw("company_code LIKE '%" . $search['value'] . "%' ");
                });
            }
            $recordsFiltered = $query->count();
            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            foreach ($data as &$d) {
                $firstName = [];
                $result = User::select('tbl_users.first_name')->join('tbl_user_company', 'tbl_users.id', '=', 'tbl_user_company.user_id')->where('tbl_user_company.company_id',$d->company_id)->get()->toArray();
                foreach($result as $r):
                    $firstName[] = $r['first_name'];
                endforeach;
                $d->users =  $firstName;
                $d->company_enabled =   $d->company_enabled == 'Y'? "Yes":"No";
                $d->action = '
                <form method="POST" action="' . route('companies.destroy', $d->company_id) . '" accept-charset="UTF-8" class="d-inline-block dform">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' . csrf_token() . '">

                <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit company details" href="' . route('companies.edit', $d->company_id) . '">
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
        $users = User::where('id', '!=',1)->get();


        return view('company.index',compact('users'));
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
    public function store(CompanyStoreRequest $request)
    {
        //$companyData = $request;
        $company = Company::insertGetId([
            'company_code' => strtoupper($request->company_code),
            'company_desc' => $request->company_desc,
            'company_enabled' => $request->company_enabled,
            'last_user_name' =>   Auth::user()->username,
            'last_time_stamp' => Carbon::now()
        ]);
        $company_id = $company;
        $all_users =  $request->users;
        $data = [];
        if(count($all_users)>0){
            for($i=0;$i<count($all_users);$i++){
                $data [] = array('user_id'=>$all_users[$i],'company_id'=>$company_id);
               }
            DB::table('tbl_user_company')->insert($data);
        }
        flash('Company created successfully!')->success();
        return redirect()->route('companies.index');
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
    public function edit(Company $company)
    {
        $title =  'Update Company';
        $users = User::where('id', '!=',1)->get();
        // $company_users = DB::table('tbl_users1')
        //     ->Leftjoin('tbl_user_company', 'tbl_users.id', '=', 'tbl_user_company.user_id')
        //     ->where('tbl_user_company.company_id',$company)
        //     ->select('tbl_user_company.*', 'tbl_user_company.user_id as company_userid')
        //     ->get();
        //     print_r($company_users);
        //     die;

        $compyUser = array();
        $company_users =  DB::table('tbl_user_company')->select('user_id')->where('company_id', '=',$company->company_id)->get();
        foreach($company_users as $cu):
            $compyUser [] = $cu->user_id;
        endforeach;

        return view('company.edit', compact('company', 'title','users','compyUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'company_code' => 'required|unique:tbl_company,company_code,' . $company->company_id . ',company_id|max:15',
        ]);
        $company->update([
            'company_code' => strtoupper($request->company_code),
            'company_desc' => $request->company_desc,
            'company_enabled' => $request->company_enabled,
            'user_name' =>   Auth::user()->username,
            'time_stamp' => Carbon::now()
        ]);
        DB::table('tbl_user_company')->where('company_id', '=',$company->company_id)->delete();
        $all_users =  $request->users;
        $data = [];
        if(count($all_users)>0){
            for($i=0;$i<count($all_users);$i++){
                $data [] = array('user_id'=>$all_users[$i],'company_id'=>$company->company_id);
               }
            DB::table('tbl_user_company')->insert($data);
        }
        flash('Company updated successfully!')->success();
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        flash('Company deleted successfully!')->info();
        return back();
    }
}
