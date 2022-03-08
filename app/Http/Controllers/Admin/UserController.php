<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:view-user')->except(['profile', 'profileUpdate']);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:update-user', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $users = User::where('name', 'like', '%'.$request->search.'%')->paginate(setting('record_per_page', 15));
        }else{
            $users= User::paginate(setting('record_per_page', 15));
        }
        $title =  'Manage Users';
        return view('users.index', compact('users','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create user';
        $roles = Role::all('name', 'id');
        $company = Company::all();
        return view('users.create', compact('roles', 'title','company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $userData = $request->except(['profile_photo','company']);
        if ($request->profile_photo) {
            $userData['profile_photo'] = parse_url($request->profile_photo, PHP_URL_PATH);
        }
        $userData['reg_date'] = Carbon::now();
        $user = User::create($userData);
        $user->assignRole($request->role);
        $all_company =  $request->company;
        $data = [];
        if(count($all_company)>0){
            for($i=0;$i<count($all_company);$i++){
                $data [] = array('user_id'=>$user->id,'company_id'=>$all_company[$i]);
               }
            DB::table('tbl_user_company')->insert($data);
        }
        flash('User created successfully!')->success();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $title = "User Details";
        $roles = Role::pluck('name', 'id');
        return view('users.show', compact('user','title', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = "User Details";
        $roles = Role::all('name', 'id');
        $company = Company::all();
        $compyUser = array();
        $company_users =  DB::table('tbl_user_company')->select('company_id')->where('user_id', '=',$user->id)->get();
        foreach($company_users as $cu):
            $compyUser [] = $cu->company_id;
        endforeach;
        $userRole = array();
        foreach($user->roles as $ru):
            $userRole [] = $ru->id;
        endforeach;
        return view('users.edit', compact('user','title', 'roles','userRole','company','compyUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $userData = $request->except(['role','password','profile_photo','company']);
        if ($request->profile_photo) {
            $userData['profile_photo'] = parse_url($request->profile_photo, PHP_URL_PATH);
        }
       if(isset($userData['active'])){
        $userData['active'] = 1;
       }else{
        $userData['active'] = 0;
       }
       if($request->password != ''){
        $userData['password'] = $request->password;
       }

        $user->update($userData);
        $user->syncRoles($request->role);
        DB::table('tbl_user_company')->where('user_id', '=',$user->id)->delete();
        $all_company =  $request->company;
        $data = [];
        if(count($all_company)>0){
            for($i=0;$i<count($all_company);$i++){
                $data [] = array('user_id'=>$user->id,'company_id'=>$all_company[$i]);
               }
            DB::table('tbl_user_company')->insert($data);
        }
        flash('User updated successfully!')->success();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == Auth::user()->id || $user->id ==1) {
            flash('You can not delete logged in user!')->warning();
            return back();
        }
        $user->delete();
        flash('User deleted successfully!')->info();
        return back();
    }


    public function profile(User $user)
    {
        $title = 'Edit Profile';
        return view('users.profile', compact('title','user'));
    }
    public function profileUpdate(UserUpdateRequest $request, User $user)
    {
        $userData = $request->except('img_path');
        if ($request->img_path) {
            $userData['img_path'] = parse_url($request->img_path, PHP_URL_PATH);
        }
        $user->update($userData);
        flash('Profile updated successfully!')->success();
        return back();
    }
}
