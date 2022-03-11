@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent"><h3 class="mb-0">Company information</h3></div>
            <div class="card-body">
                {!! Form::open(['route' => ['companies.update', $company], 'method'=>'put', 'files' => false]) !!}
                {{-- <h6 class="heading-small text-muted mb-4">Company information</h6> --}}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('company_code', $company->company_code, ['class' => 'form-control']) }}
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
                                    {{ Form::label('company_desc', 'Company Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('company_desc', $company->company_desc, ['class' => 'form-control captail_word']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_desc', 'Users', ['class' => 'form-control-label']) }}
                                    <select class="js-example-basic-multiple" name="users[]" multiple="multiple">
                                        @foreach($users as $index=>$u):
                                        <option <?php echo (in_array($u->id,$compyUser))?'selected':'';?> value="{{$u->id}}">{{$u->first_name}} {{$u->last_name}}</option>
                                        @endforeach
                                      </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('company_enabled', 'Y', $company->company_enabled!=''?true:false) }}

                                </div>
                            </div>

                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-0">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                    <a href="{{route('companies.index')}}">{{  Form::button('Back', ['class' => 'mt-0 btn btn-primary']) }}</a>

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
     $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
</script>
@endpush
