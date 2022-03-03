<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SIEMDataProcess extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_siem_data_process';
    protected $primaryKey = 'siem_data_process_id';

    protected $fillable = ['process_seq','process_date','process_ref','process_completed','user_name',
    'time_stamp','last_user_name','last_time_stamp'];

    //
}
