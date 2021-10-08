<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Auth;

class PostController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return view('frontend.post.create');
        }else{
            return redirect()->route('user/login');

        }

    }
}
