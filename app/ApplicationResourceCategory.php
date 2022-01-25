<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationResourceCategory extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_app_resource_sub_cat';
    protected $primaryKey = 'app_res_sub_cat_id';
    protected $fillable = ['app_res_cat_id','sub_cat_code','sub_cat_desc','sub_cat_enabled','user_name','time_stamp','last_user_name','last_time_stamp'];
    //
}
