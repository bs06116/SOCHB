@extends('layouts.auth')

@section('content')
<script src="https://www.google.com/recaptcha/api.js"></script>

    {{-- <div class="header py-7 py-lg-8 pt-lg-9"> --}}
        {{-- <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <img src="{{ asset('assets/img/logo-2-1.png') }}">
                        <h1 class="text-white">Welcome!</h1>
                        <p class="text-lead text-white">Enter your email and password to login your account.</p>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div> --}}
    {{-- </div> --}}
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8"> --}}
                <div class="card bg-secondary border-soft login-container">
                    <div class="card-header bg-signin">
                        <h3 class="text-muted text-center my-2">Sign In</h3>
                        @include('flash::message')
                    </div>
                    <div class="card-body px-5 pt-5 pb-4 pt-2">
                        <form method="POST" action="{{ route('login') }}" autocomplete="nope">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative input-group-login mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email') }}" required autocomplete="false" autofocus>


                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative input-group-login">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input id="password" type="password"  class="form-control @error('password') is-invalid @enderror" name="password" required   autocomplete="false">

                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            {{-- <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">

                                   <?php
                                   $company = App\Company::pluck('company_code', 'company_id');
                                ?>
                                    {{ Form::select('company_id', $company
                                    , null, ['class' => 'form-control','placeholder' => 'Select Company']) }}

                               </div>
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" id=" customCheckLogin"  name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                <label class="custom-control-label" for=" customCheckLogin">
                                    <span>Remember me</span>
                                </label>
                            </div> --}}
                            <div class="row">
                                {{-- <div class="col-12 text-right">
                                    @if (Route::has('password.request'))
                                        <a class="text-forgot" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    @endif
                                </div> --}}
                                {{-- <div class="col-6 text-right">
                                    @if (Route::has('register'))
                                        <a class="text-gray" href="{{ route('register') }}">
                                            Create new account
                                        </a>
                                    @endif
                                </div> --}}
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn--login mt-4">Login</button>
                            </div>
                            <div class="copyright">
                                Copyright &copy; 2022. All rights reserved.
                            </div>
                            {{-- <div class="form-group mt-4 mb-0">
                                <div class="alert alert-info">
                                   Admin Email : admin@email.com , Password: secret
                                </div>
                                <div class="alert alert-info">
                                    User Email : user@email.com , Password: secret
                                 </div>
                            </div> --}}
                        </form>
                    </div>
                </div>



            {{-- </div>
        </div>
    </div> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
         $(document).ready(function() {
            $('input[type="password"]').val('');
           $("form").attr('autocomplete', 'off'); // Switching form autocomplete attribute to off

           $("input").attr("autocomplete", "new-password");
});

    </script>
@endsection

