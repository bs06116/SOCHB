<div class="container-fluid main">
    <div class="row w-100">
        <div class="col-xs-2 col-sm-2   col-md-3 col-lg-3"></div>
        <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 main-div">


            <!-- Register -->
            <div class="post-container mt-4 px-3 pt-4 pb-4">
                <div class="row add-head">
                    <div class="col-12">
                        <p class="text-center">{{ __('translation.signup') }} <i
                                class="rounded-pill pull-right  fa fa-plus plus-icon nav1-btn nav2-btn text-light"
                                aria-hidden="true"></i></p>
                    </div>

                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row gx-5 mx-2  px-4">
                        <div class="col-2 text-center dropzone ">

                        </div>

                        <div class="col-8 text-center">
                            <div class="profile-images-card">
                                <div class="profile-images" >
                                  @if( !empty( $photo ) )
                                  <img src="{{$photo->temporaryUrl()}}" >
                                    @else
                                    <img src="{{ asset('assets/img/front/profile_thumbnail_large.png') }}"
                                    >
                                    @endif

                                </div>
                                <div class="custom-file">
                                    <label for="fileupload"><i
                                            class="rounded-pill pull-right  fas fa-camera plus-icon uimg-icon "
                                            aria-hidden="true"></i></label>
                                    <input type="file" wire:model="photo" id="fileupload">
                                </div>
                                @error('photo') <span class="text-danger error">{{ $message }}</span>@enderror

                            </div>


                        </div>
                        <div class="col-2 ml-2 text-center dropzone ">
                            <!-- <img src="{{ asset('assets/img/front/upload_img.png') }}" class="upload-icon" />
                 <input type="file" class="upload-input" /> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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


                    <div class="row mx-2 form-row">
                        <div class="col-12 form-col">
                            <input type="text" class="form-control form-bor text-right" wire:model="name"
                                placeholder="{{ __('translation.fullname') }}" aria-label="First name">
                        </div>
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror

                        <div class="col-12 mt-4 form-col">
                            <input type="text" class="form-control form-bor text-right"
                                placeholder="{{ __('translation.user_name') }}" wire:model="username"
                                aria-label="Username">
                        </div>
                        @error('username') <span class="text-danger error">{{ $message }}</span>@enderror

                        <div class="col-12 mt-4 form-col">
                            <input type="text" class="form-control form-bor text-right"
                                placeholder="{{ __('translation.email') }}" wire:model="email" aria-label="Email">
                        </div>
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror

                        <div class="col-12 mt-4 form-col">
                            <input type="password" class="form-control form-bor text-right"
                                placeholder="{{ __('translation.password') }}" wire:model="password"
                                aria-label="Password">
                        </div>
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror

                        <div class="col-12 py-2 mt-4 form-col">
                            <i class="fal fa-map-marker-alt"></i>
                            <select class="form-select " class="form-bor" wire:model="city"
                                aria-label="Default select example">
                                <option selected>{{ __('translation.city') }}</option>
                                {{-- <option value="1">One <img src="{{asset('assets/img/front/upload_img.png') }}"  /></option> --}} --}}
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('city') <span class="text-danger error">{{ $message }}</span>@enderror


                        <div class="col-12 mt-4 form-col">
                            <div class="input-group flex-nowrap">
                                <input type="number" class="form-control form-bor form-width text-right"
                                    wire:model="phone_number" aria-label="Number">
                                <input type="text" placeholder="+966" class=" form-control code text-right disabled"
                                    aria-label="Number">

                            </div>
                        </div>
                        @error('phone_number') <span class="text-danger error">{{ $message }}</span>@enderror

                        <div class="col-12 mt-4 form-col form-link">
                            <div class="input-group flex-nowrap ">
                                <input type="text" class=" form-control form-bor form-width text-right"
                                    wire:model="twitter_link" aria-label="Number">
                                <i class="fab fa-twitter px-2 py-2 twi"></i>

                            </div>
                        </div>
                        <div class="col-12 mt-4 form-col form-link">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control form-bor form-width text-right"
                                    wire:model="goread_link" aria-label="Number">
                                <i class="fab fa-goodreads-g px-2 py-2 good"></i>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="row d-flex pt-4 ">
                            <div class="col-6 text-right">
                                {{-- <button type="submit" class="px-4 btn submit-btn1 " >Submit</button> --}}
                            </div>
                            <div class="col-6 text-left">
                                <button type="submit" class="px-4 btn submit-btn" wire:click.prevent="registerStore">
                                    <span wire:target="registerStore"
                                        wire:loading.class="spinner-border spinner-border-sm">

                                    </span>
                                    {{ __('translation.signup') }}</button>
                            </div>
                        </div>


                    </div>

            </div>
            </form>
        </div>

        <div class="col-xs-2  col-sm-2 col-md-3 col-lg-3"></div>
    </div>


