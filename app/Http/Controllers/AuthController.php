<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Post;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Auth;


class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->to('/');
        }
        return view('frontend.login');
    }
    public function signup()
    {
        if (Auth::check()) {
            return redirect()->to('/');
        }
        return view('frontend.signup');
    }
    public function profile($username)
    {
        $user = User::where('username',$username)->first();
        $posts = $user->posts()->get();
        return view('frontend.profile',compact('user','posts'));
    }
    public function logout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }
}
