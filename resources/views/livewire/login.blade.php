<div class="container-fluid main">
    <div class="row login_page w-100">
        <div class="col-xs-2 col-sm-2   col-md-3 col-lg-3"></div>
        <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 main-div">

            <!-- Register -->
            <div class="post-container mt-4 px-3 pt-4 pb-4">
                <div class="row add-head">
                    <div class="col-12">
                        <p class="text-center">{{__('translation.login')}} </p>
                    </div>
                </div>

                <form>

                    <div class="row">
                        <div class="col-md-12 mx-4  text-right">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-row">

                        <div class="col-12 mt-4 form-col text-right">
                            <input type="text" class="form-control form-bor text-right" placeholder="{{__('translation.email')}}"
                                wire:model="email" aria-label="Email">
                        </div>
                        <div class="col-12 text-right">
                        @error('email') <span class="text-danger error text-right">{{ $message }}</span>@enderror
                        </div>
                      

                        <div class="col-12 mt-4 form-col">
                            <input type="password" class="form-control form-bor text-right" placeholder="{{__('translation.password')}}"
                                wire:model="password" aria-label="Password">
                        </div>
                        <div class="col-12 text-right">
                        @error('password') <span class="text-danger error text-right">{{ $message }}</span>@enderror
                        </div>
                        

                    </div>

                    <div class="col-12 text-center">
                        <div class="row d-flex pt-4 ">
                            <div class="col-6 text-right">
                                {{-- <button type="submit" class="px-4 btn submit-btn1 ">Submit</button> --}}
                            </div>
                            <div class="col-6 text-left">
                                <button type="submit" class=" btn  login_btn"

                                    wire:click.prevent="login">    <span wire:target="login" wire:loading.class="spinner-border spinner-border-sm"></span>
                                    {{__('translation.login')}}</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>

            <div class="col-xs-2  col-sm-2 col-md-3 col-lg-3"></div>

        </div>


    </div>
