@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('permissions.index')}}" class="btn btn-sm btn-neutral">All Permissions</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">Permission information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'permissions.store']) !!}
                        <div class="pl-lg-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name', ['class' => 'form-control-label required']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                        <small class="text-small text-muted">You can add multiple permission using comma. ex add-user, edit-user, update-user</small>
                                    </div>
                                </div>
                            </div>
                        <div class="pl-lg-1">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-3 btn btn-primary']) }}
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
