<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_vendor';
    protected $primaryKey = 'vendor_id';
    protected $fillable = ['vendor_code','vendor_desc','vendor_enabled','user_name', 'time_stamp','last_user_name','last_time_stamp'];

    //
}
