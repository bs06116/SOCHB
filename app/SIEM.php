<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SIEM extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_siem';
    protected $primaryKey = 'siem_id';

    protected $fillable = ['company_id','location_id','siem_type_id','siem_code','siem_desc','siem_enabled','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
