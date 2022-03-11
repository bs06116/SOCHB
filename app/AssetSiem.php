<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetSiem extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset_siem_link';
    protected $primaryKey = 'asset_siem_link_id';
    protected $fillable = ['asset_id','siem_id','siem_reference','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
