<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetCategoryMainType extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset_main_category';
    protected $primaryKey = 'asset_main_cat_id';
    protected $fillable = ['main_cat_code','main_cat_desc','main_cat_enabled','user_name','time_stamp','last_user_name','last_time_stamp'];
    //
}
