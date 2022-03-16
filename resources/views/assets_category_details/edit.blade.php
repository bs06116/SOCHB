@extends('layouts.app')
{{-- @push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent"><h3 class="mb-0">Asset Category Details information</h3></div>
            <div class="card-body">
                {!! Form::open(['route' => ['assetcategorydetail.update', $assetcategorydetail], 'method'=>'put', 'files' => false]) !!}
                    <div class="pl-lg-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_code', 'Code', ['class' => 'form-control-label']) }}
                                    {{ Form::text('cat_detail_code', $assetcategorydetail->cat_detail_code, ['class' => 'form-control captail_word']) }}
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
                                    {{ Form::textarea('cat_detail_desc', $assetcategorydetail->cat_detail_enabled, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('vendor_id', 'Vendor', ['class' => 'form-control-label']) }}
                                    {{ Form::select('principal_id',$vendors,$assetcategorydetail->principal_id, ['class' => 'form-control']) }}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_main_id', 'Main Type', ['class' => 'form-control-label']) }}
                                    {{-- {{ Form::select('asset_sub_main_id',$assetcategorymaintype,$assetcategorydetail->asset_main_cat_id, ['class' => 'form-control']) }} --}}
                                    <select name="asset_sub_main_id" id="main_catgory" onchange="getSubCategory(this.value)"
                                    class="form-control">
                                    @foreach ($assetcategorymaintype as $acm)
                                        <option <?php if($assetcategorydetail->asset_sub_main_id ==  $acm->asset_main_cat_id){echo 'selected';} ?>  value="{{ $acm->asset_main_cat_id }}">{{ $acm->main_cat_code }}</option>
                                    @endforeach

                                </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('asset_sub_cat_id', 'Sub Type', ['class' => 'form-control-label']) }}
                                    {{-- {{ Form::select('asset_sub_cat_id',$assetcategorysubtype, $assetcategorydetail->asset_sub_cat_id, ['class' => 'form-control']) }} --}}
                                    <select name="asset_sub_cat_id"  id="select-subcategory" data-required="required" class="form-control" >

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('cat_detail_enabled', 'Enabled', ['class' => 'form-control-label']) }}
                                    {{ Form::checkbox('cat_detail_enabled', 'Y', $assetcategorydetail->cat_detail_enabled!=''?true:false) }}

                                </div>
                            </div>

                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-0">
                            <div class="row">

                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-0 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>

                    </div>

                {!! Form::close() !!}
                <input type="hidden" value="<?php echo $assetcategorydetail->asset_sub_cat_id; ?>" id="asset_sub_id">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
       $( document ).ready(function() {
            getSubCategory('<?php echo $assetcategorydetail->asset_sub_main_id; ?>');
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
                            if($("#asset_sub_id").val() == response.result[i].asset_sub_cat_id){ selected_subtype = 'selected';}else{ selected_subtype = '';}
                            opts +=
                                `<option ${selected_subtype} value="${response.result[i].asset_sub_cat_id}">${response.result[i].sub_cat_code}</option>`;
                        }
                        $("#select-subcategory").html(opts);
                    }
                },
            });
        }
</script>

@endpush
