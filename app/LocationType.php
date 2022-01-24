<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_location_type';
    protected $primaryKey = 'location_type_id';
    protected $fillable = ['loc_type_code','loc_type_desc','loc_type_enabled','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
