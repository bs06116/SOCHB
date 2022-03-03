@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['route' => ['applicationresourcecategory.update', $applicationresourcecategory], 'method'=>'put', 'files' => false]) !!}
                <h6 class="heading-small text-muted mb-4">Application Resource Category information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('sub_cat_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('sub_cat_code', $applicationresourcecategory->sub_cat_code, ['class' => 'form-control captail_word']) }}
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
                                    {{ Form::label('sub_cat_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('sub_cat_desc', $applicationresourcecategory->sub_cat_desc, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_main_cat_id', 'Main Type', ['class' => 'form-control-label']) }}
                                    {{ Form::select('asset_main_cat_id',$assetresourcemaintype,$applicationresourcecategory->asset_main_cat_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('sub_cat_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('sub_cat_enabled', 'Y', $applicationresourcecategory->sub_cat_enabled!=''?true:false) }}

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