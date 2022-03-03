<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetManagement extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset';
    protected $primaryKey = 'asset_id';
    protected $fillable = ['company_id','asset_code','ip_address','host_name','domain_name','asset_desc','asset_enabled',
    'asset_cat_detail_id','app_res_sub_cat_id','asset_app_id','location_id','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
