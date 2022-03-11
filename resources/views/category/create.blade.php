@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('category.index')}}" class="btn btn-sm btn-neutral">All category</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">Category information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'category.store']) !!}
                        <div class="pl-lg-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('category_name', 'Category Name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('category_name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="status" value="1" class="custom-control-input" id="status">
                                        {{ Form::label('status', 'Status', ['class' => 'custom-control-label']) }}
                                    </div>
                                </div>
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
