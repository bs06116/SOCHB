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
                <div class="card-header bg-transparent"><h3 class="mb-0">Asset Application information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'assetapplication.store']) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_app_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('asset_app_code', null, ['class' => 'form-control']) }}
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
                                    {{ Form::label('asset_app_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('asset_app_desc', null, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                    {{ Form::select('company_id',$company, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            @can('manage-company')
                            <a href="{{ route('companies.index')}}" class="form-group form-group-add">Add</a>
                            @endcan

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('vendor_id', 'Vednor', ['class' => 'form-control-label']) }}
                                    {{ Form::select('principal_id',$vendor, null, ['class' => 'form-control']) }}

                                </div>
                            </div>
                            @can('manage-vednor')
                            <a href="{{ route('vendors.index')}}" class="form-group form-group-add">Add</a>
                            @endcan

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_app_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('asset_app_enabled', 'Y', true) }}

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
                            <h3 class="mb-0">All Asset Application</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Sr</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Descripton</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Company</th>

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
                    url: "{{ route('assetapplication.index') }}",
                    data: function(d) {
                        //   d.approved = $('#approved').val(),
                        //  d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'asset_app_id',
                        name: 'asset_app_id'
                    },
                     {
                        data: 'asset_app_code',
                        name: 'asset_app_code'
                    },
                    {
                        data: 'asset_app_desc',
                        name: 'asset_app_desc'
                    },
                    {
                        data: 'asset_app_enabled',
                        name: 'asset_app_enabled'
                    },
                    {
                        data: 'principal_code',
                        name: 'principal_code'
                    },
                    {
                        data: 'company_code',
                        name: 'company_code'
                    },

                    {
                        data: 'action',
                        name: 'actions'
                    }
                ],"fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                }

            }

            );

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
