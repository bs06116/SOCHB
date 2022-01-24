<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SIEMType extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_siem_type';
    protected $primaryKey = 'siem_type_id';
    protected $fillable = ['siem_type_code','siem_type_desc','siem_type_enabled'];

    //
}
