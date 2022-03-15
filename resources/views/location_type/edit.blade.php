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

                {!! Form::open(['route' => ['locationstype.update', $locationstype], 'method'=>'put', 'files' => false]) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('loc_type_code', 'Code', ['class' => 'form-control-label']) }}
                                            {{ Form::text('loc_type_code', $locationstype->loc_type_code, ['class' => 'form-control captail_word']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('loc_type_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                            {{ Form::checkbox('loc_type_enabled', 'Y', $locationstype->loc_type_enabled!=''?true:false) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('loc_type_desc', 'Company Description', ['class' => 'form-control-label']) }}
                                            {{ Form::textarea('loc_type_desc', $locationstype->loc_type_desc, ['class' => 'form-control']) }}
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
