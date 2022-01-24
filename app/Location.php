<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_location';
    protected $primaryKey = 'location_id';
    protected $fillable = ['location_code','location_desc','location_enabled','company_id','location_type_id','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
