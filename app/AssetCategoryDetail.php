<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetCategoryDetail extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_asset_category_detail';
    protected $primaryKey = 'asset_cat_detail_id';

    protected $fillable = ['vendor_id','asset_sub_main_id','asset_sub_cat_id','cat_detail_code','cat_detail_desc','cat_detail_enabled','main_cat_enabled','user_name',
    'time_stamp','last_user_name','last_time_stamp'];
    //
}
