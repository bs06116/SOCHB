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
                {!! Form::open(['route' => ['siem.update', $siem], 'method'=>'put', 'files' => false]) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_code', 'Code', ['class' => 'form-control-label required']) }}
                                    {{ Form::text('siem_code', $siem->siem_code, ['class' => 'form-control captail_word']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                    {{ Form::select('company_id',$companies,$siem->company_id, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group add-form-group">
                                            {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                    {{ Form::select('location_id',$location,$siem->location_id, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group add-form-group">
                                            {{ Form::label('siem_type_id', 'siem Type', ['class' => 'form-control-label']) }}
                                    {{ Form::select('siem_type_id',$siemType, $siem->siem_type_id, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('siem_enabled', 'Y', $siem->siem_enabled!=''?true:false) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_desc', 'Company Description', ['class' => 'form-control-label']) }}
                                            {{ Form::textarea('siem_desc', $siem->siem_desc, ['class' => 'form-control']) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr class="my-4" />
                        <div class="pl-lg-0">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                    <a href="{{route('siem.index')}}">{{  Form::button('Back', ['class' => 'mt-0 btn btn-primary']) }}</a>
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
