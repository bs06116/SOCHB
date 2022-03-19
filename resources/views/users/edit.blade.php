@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">User information</h3></div>
                <div class="card-body">
                    @can('update-user')
                    {!! Form::open(['route' => ['users.update', $user], 'method'=>'put', 'files' => true]) !!}
                    @endcan
                        <div class="pl-lg-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('first_name', 'First Name', ['class' => 'form-control-label required']) }}
                                        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('last_name', 'Last Name', ['class' => 'form-control-label required']) }}
                                        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('email', 'E-mail', ['class' => 'form-control-label required']) }}
                                        {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('city', 'City', ['class' => 'form-control-label']) }}
                                        {{ Form::text('city', $user->city, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label required']) }}
                                        {{ Form::text('phone', $user->phone, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        {{-- {{$user->roles->sync([1])                                    }} --}}
                                        {{ Form::label('role', 'Select Role', ['class' => 'form-control-label']) }}
                                        <select class="js-example-basic-multiple" name="role[]" multiple="multiple">
                                            @foreach($roles as $r):
                                            <option <?php echo (in_array($r->id,$userRole))?'selected':'';?> value="{{$r->id}}">{{$r->name}} </option>
                                            @endforeach
                                          </select>
                                        {{-- {{ Form::select('role', $roles, $user->roles, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select role...']) }} --}}
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('profile_photo', 'Photo', ['class' => 'form-control-label d-block']) }}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                              <a id="uploadFile" data-input="thumbnail" data-preview="holder" class="btn btn-secondary">
                                                <i class="fa fa-picture-o"></i> Choose Photo
                                              </a>
                                            </span>
                                            <input id="thumbnail" class="form-control d-none" type="text" name="profile_photo">
                                        </div>
                                </div> --}}
                            </div>

                                        {{-- <div class="col-md-2">
                                            @if ($user->profile_photo)
                                                <a href="{{ asset($user->profile_photo) }}" target="_blank">
                                                    <img alt="Image placeholder"
                                                    class="avatar avatar-xl  rounded-circle"
                                                    data-toggle="tooltip" data-original-title="{{ $user->name }} Logo"
                                                    src="{{ asset($user->profile_photo) }}">
                                                </a>
                                            @endif
                                    </div> --}}
                                    <div class="row">


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('company', 'Assing Company', ['class' => 'form-control-label']) }}
                                                <select class="js-example-basic-multiple" name="company[]" multiple="multiple">
                                                    @foreach($company as $c):
                                                    <option  <?php echo (in_array($c->company_id,$compyUser))?'selected':'';?> value="{{$c->company_id}}">{{$c->company_code}}</option>
                                                    @endforeach
                                                  </select>
                                                {{-- {{ Form::select2('role', $roles, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select role...']) }} --}}
                                            </div>
                                        </div>

                                    </div>

                            </div>


                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        {{-- <h6 class="heading-small text-muted mb-4">Password information</h6> --}}
                        <div class="card-header bg-transparent border-0"><h3 class="mb-0">Password information</h3></div>
                        <div class="pl-lg-4 pr-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password', ['class' => 'form-control-label required']) }}
                                        {{ Form::password('password', ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Confirm password', ['class' => 'form-control-label required']) }}
                                        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status', ['class' => 'form-control-label']) }}
                                        {{ Form::checkbox('active', 1, $user->active!=''?true:false) }}

                                    </div>
                                </div>

                            </div>

                                @can('update-user')
                                <div class="col-md-12 pl-0">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                    <a href="{{route('users.index')}}">{{  Form::button('Back', ['class' => 'mt-0 btn btn-primary']) }}</a>
                                </div>
                                @endcan
                                <br><br>
                            </div>
                        </div>

                    @can('update-user')
                    {!! Form::close() !!}
                    @endcan
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            $('.js-example-basic-multiple').select2();

            jQuery('#uploadFile').filemanager('file');
        })
    </script>
@endpush
