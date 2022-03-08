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
                                    <select name="company_id"  onchange="getOhterData(this.value)"
                                        class="form-control">
                                        <option value="" selected disabled>Select Company</option>
                                        @foreach ($company as $c)
                                        <option value="{{ $c->company_id }}">{{ $c->company_code }}</option>
                                        @endforeach

                                </select>
                                    {{-- {{ Form::select('company_id',$company, null, ['class' => 'form-control']) }} --}}

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                    {{-- {{ Form::select('location_id',$location, null, ['class' => 'form-control']) }} --}}
                                    <select name="location_id"  id="select-location" data-required="required" class="form-control" >
                                        {{-- <option selected disabled>Select City</option> --}}
                                    </select>

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

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('process_siem', 'SIEM', ['class' => 'form-control-label']) }}
                            <select name="siem"  id="select-siem" data-required="required" class="form-control" >
                                {{-- <option selected disabled>Select City</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('refer', 'Ref', ['class' => 'form-control-label']) }}
                            {{ Form::text('process_ref', null, ['class' => 'form-control','id'=>"ref"]) }}
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <input class="mt-5 btn btn-primary" onclick="saveRef()" type="button" value="Add">
                        </div>
                    </div>
                    <table>
                        <tr>
                          <th>SIEM</th>
                          <th>Ref</th>
                          <th>Delete</th>
                        </tr>
                        <tbody id="tbody">
                        </tbody>
                      </table>
                        <hr class="my-4" />



                        <div class="pl-lg-4">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class' => 'mt-5 btn btn-primary']) }}
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
                                        <th scope="col">Reffernce</th>
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
                        data: 'siem_reffernce',
                        name: 'siem_reffernce'
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
        function saveRef(){
            var siem = $('#select-siem').children(':selected').text();
            var siemVal = $('#select-siem').children(':selected').val();
            var ref = $('#ref').val();
            var append_html = '<tr><input type="hidden" name="siem[]" value="'+siemVal+'"><input type="hidden" name="ref[]" value="'+ref+'"><td>'+siem+'</td><td>'+ref+'</td><td><button onclick="deleteRef(this)">Delete</button></td></tr>';
            $('#tbody').append(append_html);
            $('#ref').val('');
        }
        function deleteRef(e){
            $(e).parent().parent().remove();
        }
        function getOhterData(id){
            getSIEM(id);
            getLocation(id);

        }
        function getLocation(company_id ) {
            $.ajax({
                url: "{{ route('assetmanagement.loadLocation') }}",
                type: "POST",
                data: {
                    company_id : company_id ,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response) {
                        var opts =
                        `<option  disabled="" >Select Location</option>`;
                        for (var i = 0; i < response.result.length; i++) {
                            opts +=
                                `<option value="${response.result[i].location_id }">${response.result[i].location_code}</option>`;
                        }
                        $("#select-location").html(opts);
                    }
                },
            });
        }
        function getSIEM(company_id ) {
            $.ajax({
                url: "{{ route('assetmanagement.loadSIEM') }}",
                type: "POST",
                data: {
                    company_id : company_id ,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response) {
                        var opts =
                        `<option  disabled="" >Select SIEM</option>`;
                        for (var i = 0; i < response.result.length; i++) {
                            opts +=
                                `<option value="${response.result[i].siem_id }">${response.result[i].siem_code}</option>`;
                        }
                        $("#select-siem").html(opts);
                    }
                },
            });
        }
    </script>
@endpush
