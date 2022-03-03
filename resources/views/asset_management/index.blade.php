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
                <div class="card-body">
                    {!! Form::open(['route' => 'assetmanagement.store']) !!}
                    <h6 class="heading-small text-muted mb-4">Asset Management information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('asset_code', null, ['class' => 'form-control captail_word']) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('ip_address', 'IP Address', ['class' => 'form-control-label']) }}
                                    {{ Form::text('ip_address', null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('host_name', 'Host Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('host_name', null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('domain_name', 'Domain Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('domain_name', null, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('asset_desc', null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                    {{ Form::select('company_id',$company, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                    {{ Form::select('location_id',$location, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_cat_detail_id', 'Category', ['class' => 'form-control-label']) }}
                                    {{ Form::select('asset_cat_detail_id',$asetcategorydetail, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('app_res_sub_cat_id', 'Application Resource', ['class' => 'form-control-label']) }}
                                    {{ Form::select('app_res_sub_cat_id',$applicationresourcecategory, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_app_id', 'Application', ['class' => 'form-control-label']) }}
                                    {{ Form::select('asset_app_id',$assetapplication, null, ['class' => 'form-control']) }}

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
                        {{-- {!! Form::open(['route' => 'storeSIEMRef']) !!}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('refer', 'Ref', ['class' => 'form-control-label']) }}
                                    {{ Form::text('process_ref', null, ['class' => 'form-control']) }}

                                </div>
                            </div>


                        </div>

                        {{ Form::submit('Save', ['class' => 'mt-5 btn btn-primary']) }}
                        {!! Form::close() !!} --}}


                        <div class="pl-lg-4">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class' => 'mt-5 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    {!! Form::close() !!}

                    {!! Form::open(['route' => 'storeSIEMRef']) !!}


                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('process_seq', 'SIEM', ['class' => 'form-control-label']) }}
                            {{ Form::select('process_seq',$siem, null, ['class' => 'form-control']) }}

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('refer', 'Ref', ['class' => 'form-control-label']) }}
                            {{ Form::text('process_ref', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    {{ Form::submit('Save', ['class' => 'mt-5 btn btn-primary']) }}
                    {!! Form::close() !!}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5">
                            <div class="card-header bg-transparent">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h3 class="mb-0">All Asset Management</h3>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-hover align-items-center data-table-siem-reff">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Ref</th>
                                                    <th scope="col">Action</th>

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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All Asset Management</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">Host Name</th>
                                        <th scope="col">Domain</th>
                                        <th scope="col">Descripton</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Application Resource</th>
                                        <th scope="col">Application</th>
                                        <th scope="col">Status</th>
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
        var table = $('.data-table-siem-reff').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('assetmanagement.loadSIEMRef') }}",
                data: function(d) {
                    //   d.approved = $('#approved').val(),
                    //  d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                {
                    data: 'siem_data_process_id',
                    name: 'siem_data_process_id'
                },
                {
                    data: 'process_ref',
                    name: 'process_ref'
                },
                {
                    data: 'action',
                    name: 'actions'
                },

            ]

        }

        );

        //   $('#approved').change(function(){
        //       table.draw();
        //   });

    });
</script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('assetmanagement.index') }}",
                    data: function(d) {
                        //   d.approved = $('#approved').val(),
                        //  d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'asset_id',
                        name: 'asset_id'
                    },
                    {
                        data: 'asset_code',
                        name: 'asset_code'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'host_name',
                        name: 'host_name'
                    },
                    {
                        data: 'domain_name',
                        name: 'domain_name'
                    },
                    {
                        data: 'asset_desc',
                        name: 'asset_desc'
                    },
                    {
                        data: 'company_code',
                        name: 'company_code'
                    },
                    {
                        data: 'location_code',
                        name: 'location_code'
                    },
                    {
                        data: 'cat_detail_code',
                        name: 'cat_detail_code'
                    },
                    {
                        data: 'sub_cat_code',
                        name: 'sub_cat_code'
                    },
                    {
                        data: 'asset_app_code',
                        name: 'asset_app_code'
                    },
                    {
                        data: 'asset_enabled',
                        name: 'asset_enabled'
                    },

                    {
                        data: 'action',
                        name: 'actions'
                    }
                ]

            }

            );

            //   $('#approved').change(function(){
            //       table.draw();
            //   });

        });
    </script>
    <script>
        $('.data-table-siem-reff tbody').on('click', '.delete', function(e) {
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
