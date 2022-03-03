<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetApplication extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset_application';
    protected $primaryKey = 'asset_app_id';
    protected $fillable = ['vendor_id','company_id','asset_app_code','asset_app_desc','asset_app_enabled','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
