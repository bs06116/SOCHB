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
                <div class="card-header bg-transparent"><h3 class="mb-0">Asset Category Main Type information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'assetcategorymaintype.store']) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('main_cat_code', 'Code', ['class' => 'form-control-label required']) }}
                                    {{ Form::text('main_cat_code', null, ['class' => 'form-control captail_word']) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('main_cat_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('main_cat_enabled', 'Y', true) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('main_cat_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('main_cat_desc', null, ['class' => 'form-control']) }}
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
                            <h3 class="mb-0">All SIEM Type</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Descripton</th>
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
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('assetcategorymaintype.index') }}",
                    data: function(d) {
                        //   d.approved = $('#approved').val(),
                        //  d.search = $('input[type="search"]').val()
                    }
                },
                columns: [

                    {
                        data: 'asset_main_cat_id',
                        name: 'asset_main_cat_id'
                    },
                                       {
                        data: 'main_cat_code',
                        name: 'main_cat_code'
                    },
                    {
                        data: 'main_cat_desc',
                        name: 'main_cat_desc'
                    },
                    {
                        data: 'main_cat_enabled',
                        name: 'main_cat_enabled'
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
