<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_company';
    protected $primaryKey = 'company_id';
    protected $fillable = ['company_code','company_desc','company_enabled','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
