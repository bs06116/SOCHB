@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('roles.index')}}" class="btn btn-sm btn-neutral">All Roles</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">Role information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'roles.store']) !!}
                        <div class="pl-lg-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name', ['class' => 'form-control-label required']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        <hr class="my-4" />
                        <div class="pl-lg-1">
                            <div class="row">
                                    <div class="col-lg-6">
                                        @foreach ($permissions as $key => $permission)
                                        <div class="form-group p-2 d-inline-block">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" value="{{ $key }}" class="custom-control-input" id="{{ $permission }}">
                                                {{ Form::label($permission, $permission, ['class' => 'custom-control-label']) }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                        <div class="pl-lg-1">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
