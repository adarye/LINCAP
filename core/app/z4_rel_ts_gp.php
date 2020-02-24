<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class z4_rel_ts_gp extends Model
{
    protected $table = 'z4_rel_ts_gps';
    protected $primaryKey = 'cz4_id';
    public $timestamps = true;

    // public function getDateFormat()
    // {
    //     return 'Y-d-m H:i:s.u0';
    // }
}

