<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetResourceMainType extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_app_resource_category';
    protected $primaryKey = 'app_res_cat_id';
    protected $fillable = ['res_cat_code','res_cat_desc','res_cat_enabled','user_name','time_stamp','last_user_name','last_time_stamp'];
    //
}
