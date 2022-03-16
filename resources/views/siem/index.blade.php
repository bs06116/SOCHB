@extends('layouts.app')
@push('pg_btn')
    {{-- @can('create-user')
    <a href="{{ route('company.create') }}" class="btn btn-sm btn-neutral">Create New User</a>
@endcan --}}
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">SIEM information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'siem.store']) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_code', 'Code', ['class' => 'form-control-label']) }}
                                            {{ Form::text('siem_code', null, ['class' => 'form-control captail_word']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_desc', 'SIEM Description', ['class' => 'form-control-label']) }}
                                            {{ Form::textarea('siem_desc', null, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                            {{ Form::select('company_id', $companies,null, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                            {{ Form::select('location_id',$location, null, ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12 add-form-col">
                                        <div class="form-group add-form-group">
                                            {{ Form::label('siem_type_id', 'SIEM Type', ['class' => 'form-control-label']) }}
                                            {{ Form::select('siem_type_id',$siemType, null, ['class' => 'form-control']) }}
                                        </div>
                                        @can('manage-siem-type')

                                        <a href="{{ route('siemtype.index')}}" class="form-group form-group-add">Add</a>
                                        @endcan

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('siem_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                            {{ Form::checkbox('siem_enabled', 'Y', true) }}
                                        </div>
                                    </div>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All SIEM</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>

                                        <th scope="col">Code</th>
                                        <th scope="col">Descripton</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Type</th>

                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('siem.index') }}",
                    data: function(d) {
                        //   d.approved = $('#approved').val(),
                        //  d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'siem_id',
                        name: 'siem_id'
                    },
                    {
                        data: 'siem_code',
                        name: 'siem_code'
                    },
                    {
                        data: 'siem_desc',
                        name: 'siem_desc'
                    },
                    {
                        data: 'siem_enabled',
                        name: 'siem_enabled'
                    },
                    {
                        data: 'company_code',
                        name: 'company_txt',
                        orderable:false,searchable:false
                    },
                    {
                        data: 'location_code',
                        name: 'location_txt',
                        orderable:false,searchable:false
                    },
                    {
                        data: 'siem_type_code',
                        name: 'siem_type_txt',
                        orderable:false,searchable:false
                    },
                    {
                        data: 'action',
                        name: 'actions'
                    }
                ]
            });

            //   $('#approved').change(function(){
            //       table.draw();
            //   });

        });
    </script>
    <script>
        $('.data-table tbody').on('click', '.delete', function(e) {
                e.preventDefault();
                let that = jQuery(this);
                jQuery.confirm({
                    icon: 'fas fa-wind-warning',
                    closeIcon: true,
                    title: 'Are you sure!',
                    content: 'You can not undo this action.!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        confirm: function() {
                            that.parent('form').submit();
                            //$.alert('Confirmed!');
                        },
                        cancel: function() {
                            //$.alert('Canceled!');
                        }
                    }
                });

        });
    </script>
@endpush
