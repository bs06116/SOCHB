@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent"><h3 class="mb-0">Asset Management information</h3></div>
            <div class="card-body">
                {!! Form::open(['route' => ['assetmanagement.update',$assetmanagement], 'method'=>'put', 'files' => false]) !!}
                <div class="pl-lg-0">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_code', 'Code', ['class' => 'form-control-label']) }}
                                {{ Form::text('asset_code', $assetmanagement->asset_code, ['class' => 'form-control captail_word']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('ip_address', 'IP Address', ['class' => 'form-control-label']) }}
                                {{ Form::text('ip_address',  $assetmanagement->ip_address, ['class' => 'form-control']) }}

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('host_name', 'Host Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('host_name',  $assetmanagement->host_name, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('domain_name', 'Domain Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('domain_name',  $assetmanagement->domain_name, ['class' => 'form-control']) }}

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_desc', 'Description', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('asset_desc',  $assetmanagement->asset_desc, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                {{ Form::select('company_id',$company,  $assetmanagement->company_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                {{ Form::select('location_id',$location,  $assetmanagement->location_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_cat_detail_id', 'Category', ['class' => 'form-control-label']) }}
                                {{ Form::select('asset_cat_detail_id',$asetcategorydetail,  $assetmanagement->asset_cat_detail_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('app_res_sub_cat_id', 'Application Resource', ['class' => 'form-control-label']) }}
                                {{ Form::select('app_res_sub_cat_id',$applicationresourcecategory,  $assetmanagement->app_res_sub_cat_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_app_id', 'Application', ['class' => 'form-control-label']) }}
                                {{ Form::select('asset_app_id',$assetapplication,  $assetmanagement->asset_app_id, ['class' => 'form-control']) }}

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                {{ Form::checkbox('asset_enabled', 'Y', true) }}

                            </div>
                        </div>

                    </div>
                    <hr class="my-4" />
                    <div class="pl-lg-0">
                        <div class="row">

                            <div class="col-md-12">
                                {{ Form::submit('Submit', ['class' => 'mt-0 btn btn-primary']) }}
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
