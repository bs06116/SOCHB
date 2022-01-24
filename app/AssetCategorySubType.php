<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetCategorySubType extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset_sub_category';
    protected $primaryKey = 'asset_sub_cat_id';
    protected $fillable = ['asset_main_cat_id','sub_cat_code','sub_cat_desc','sub_cat_enabled','user_name','time_stamp','last_user_name','last_time_stamp'];
    //
}
