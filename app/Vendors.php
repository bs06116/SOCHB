<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_principal';
    protected $primaryKey = 'principal_id';
    protected $fillable = ['principal_code','principal_desc','principal_enabled	','user_name', 'time_stamp','last_user_name','last_time_stamp'];
    //
}
