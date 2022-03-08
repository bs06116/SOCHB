@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['route' => ['assetmanagement.update',$assetmanagement], 'method'=>'put', 'files' => false]) !!}
                <h6 class="heading-small text-muted mb-4">Asset Management information</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_code', 'Code', ['class' => 'form-control-label']) }}
                                {{ Form::text('asset_code', $assetmanagement->asset_code, ['class' => 'form-control captail_word']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('ip_address', 'IP Address', ['class' => 'form-control-label']) }}
                                {{ Form::text('ip_address',  $assetmanagement->ip_address, ['class' => 'form-control']) }}

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('host_name', 'Host Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('host_name',  $assetmanagement->host_name, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('domain_name', 'Domain Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('domain_name',  $assetmanagement->domain_name, ['class' => 'form-control']) }}

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_desc', 'Description', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('asset_desc',  $assetmanagement->asset_desc, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('company_id', 'Company', ['class' => 'form-control-label']) }}
                                {{-- {{ Form::select('company_id',$company,  $assetmanagement->company_id, ['class' => 'form-control']) }} --}}
                                <select name="company_id"  onchange="getOhterData(this.value)"
                                class="form-control">
                                <option value="" selected disabled>Select Company</option>
                                @foreach ($company as $c)
                                <option <?php if($assetmanagement->company_id == $c->company_id ){ echo "selected";}?> value="{{ $c->company_id }}">{{ $c->company_code }}</option>
                                @endforeach

                        </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('location_id', 'Location', ['class' => 'form-control-label']) }}
                                {{-- {{ Form::select('location_id',$location,  $assetmanagement->location_id, ['class' => 'form-control']) }} --}}
                                <select name="location_id"  id="select-location" data-required="required" class="form-control" >
                                    {{-- <option selected disabled>Select City</option> --}}
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_cat_detail_id', 'Category', ['class' => 'form-control-label']) }}
                                {{ Form::select('asset_cat_detail_id',$asetcategorydetail,  $assetmanagement->asset_cat_detail_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('app_res_sub_cat_id', 'Application Resource', ['class' => 'form-control-label']) }}
                                {{ Form::select('app_res_sub_cat_id',$applicationresourcecategory,  $assetmanagement->app_res_sub_cat_id, ['class' => 'form-control']) }}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('asset_app_id', 'Application', ['class' => 'form-control-label']) }}
                                {{ Form::select('asset_app_id',$assetapplication,  $assetmanagement->asset_app_id, ['class' => 'form-control']) }}

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
@endsection

@push('scripts')
    <script>
        $(function() {
            getOhterData('<?php echo $assetmanagement->company_id?>');
        });
         function saveRef(){
            var siem = $('#select-siem').children(':selected').text();
            var siemVal = $('#select-siem').children(':selected').val();
            var ref = $('#ref').val();
            var append_html = '<tr><input type="hidden" name="siem[]" value="'+siemVal+'"><input type="hidden" name="ref[]" value="'+ref+'"><td>'+siem+'</td><td>'+ref+'</td><td><button class="btn btn-danger" onclick="deleteRef(this)">Delete</button></td></tr>';
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
                            if(company_id== response.result[i].location_id){ selected_subtype = 'selected';}else{ selected_subtype = '';}
                            opts +=
                                `<option ${selected_subtype} value="${response.result[i].location_id }">${response.result[i].location_code}</option>`;
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
