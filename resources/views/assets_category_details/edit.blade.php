@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['route' => ['assetcategorydetail.update', $assetcategorydetail], 'method'=>'put', 'files' => false]) !!}
                <h6 class="heading-small text-muted mb-4">Asset Category Details information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('cat_detail_code', $assetcategorydetail->cat_detail_code, ['class' => 'form-control']) }}
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
                                    {{ Form::label('cat_detail_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('cat_detail_desc', $assetcategorydetail->cat_detail_enabled, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('vendor_id', 'Vendor', ['class' => 'form-control-label']) }}
                                    {{ Form::select('vendor_id',$vendors,$assetcategorydetail->vendor_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_main_id', 'Main Type', ['class' => 'form-control-label']) }}
                                    {{ Form::select('asset_sub_main_id',$assetcategorymaintype,$assetcategorydetail->asset_main_cat_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_cat_id', 'Sub Type', ['class' => 'form-control-label']) }}
                                    {{ Form::select('asset_sub_cat_id',$assetcategorysubtype, $assetcategorydetail->asset_sub_cat_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('cat_detail_enabled', 'Y', $assetcategorydetail->cat_detail_enabled!=''?true:false) }}

                                </div>
                            </div>

                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary']) }}
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
