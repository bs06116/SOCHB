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
                <div class="card-header bg-transparent"><h3 class="mb-0">Asset Category Details information</h3></div>
                <div class="card-body">
                    {!! Form::open(['route' => 'assetcategorydetail.store']) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('cat_detail_code', null, ['class' => 'form-control captail_word']) }}
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
                                    {{ Form::label('cat_detail_desc', 'Description', ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('cat_detail_desc', null, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('vendor_id', 'Vendor', ['class' => 'form-control-label']) }}
                                    {{ Form::select('principal_id', $vendors,null, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_main_id', 'Main Type', ['class' => 'form-control-label']) }}
                                    <select name="asset_sub_main_id" id="main_catgory" onchange="getSubCategory(this.value)"
                                    class="form-control">
                                    <option value="" selected disabled>Select Main Category</option>
                                    @foreach ($assetcategorymaintype as $acm)
                                        <option value="{{ $acm->asset_main_cat_id }}">{{ $acm->main_cat_code }}</option>
                                    @endforeach

                                </select>
                                    {{-- {{ Form::select('asset_sub_main_id',$assetcategorymaintype, null, ['class' => 'form-control']) }} --}}

                                </div>
                            </div>
                            @can('manage-asset-category-main-type')

                            <a href="{{ route('assetcategorymaintype.index')}}" class="form-group form-group-add">Add</a>
                            @endcan

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_cat_id', 'Sub Type', ['class' => 'form-control-label']) }}
                                    <select name="asset_sub_cat_id"  id="select-subcategory" data-required="required" class="form-control" >
                                        {{-- <option selected disabled>Select City</option> --}}

                                    </select>
                                    {{-- {{ Form::select('asset_sub_cat_id',$assetcategorysubtype, null, ['class' => 'form-control']) }} --}}

                                </div>
                            </div>
                            @can('manage-asset-category-sub-type')
                            <a href="{{ route('assetcategorysubtype.index')}}" class="form-group form-group-add">Add</a>
                            @endcan

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('cat_detail_enabled', 'Y', true) }}

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
                                        <th scope="col">id</th>

                                        <th scope="col">Code</th>
                                        <th scope="col">Descripton</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Main Type</th>
                                        <th scope="col">Sub Type</th>

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
                    url: "{{ route('assetcategorydetail.index') }}",
                    data: function(d) {
                        //   d.approved = $('#approved').val(),
                        //  d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'asset_cat_detail_id',
                        name: 'asset_cat_detail_id'
                    },{
                        data: 'cat_detail_code',
                        name: 'cat_detail_code'
                    },
                    {
                        data: 'cat_detail_desc',
                        name: 'cat_detail_desc'
                    },
                    {
                        data: 'cat_detail_enabled',
                        name: 'cat_detail_enabled'
                    },
                    {
                        data: 'principal_code',
                        name: 'vendor_code_txt'
                    },
                    {
                        data: 'main_cat_code',
                        name: 'main_cat_txt'
                    },
                    {
                        data: 'sub_cat_code',
                        name: 'sub_cat_text'
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
        function getSubCategory(categoryId) {
            $.ajax({
                url: "{{ route('assetcategorydetail.loadSubType') }}",
                type: "POST",
                data: {
                    category_id: categoryId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response) {
                        var opts =
                        `<option value="Select a model" disabled="" selected="">Select Sub Type</option>`;
                        for (var i = 0; i < response.result.length; i++) {
                            opts +=
                                `<option value="${response.result[i].asset_sub_cat_id}">${response.result[i].sub_cat_code}</option>`;
                        }
                        $("#select-subcategory").html(opts);
                    }
                },
            });
        }
    </script>
@endpush
