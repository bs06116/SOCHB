@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent"><h3 class="mb-0">Location information</h3></div>
            <div class="card-body">
                {!! Form::open(['route' => ['locations.update', $location], 'method'=>'put', 'files' => false]) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('location_code', $location->location_code, ['class' => 'form-control captail_word']) }}
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('email', 'E-mail', ['class' => 'form-control-label']) }}
                                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_desc', 'Company Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('location_desc', $location->location_desc, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                    {{ Form::select('company_id',$companies,$location->company_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_type_id', 'Location Type', ['class' => 'form-control-label']) }}
                                    {{ Form::select('location_type_id',$locationType, $location->location_type_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('location_enabled', 'Y', $location->location_enabled!=''?true:false) }}

                                </div>
                            </div>

                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-0">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>

                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
