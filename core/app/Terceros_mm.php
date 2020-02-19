<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terceros_mm extends Model
{
    protected $table = 'dbo.t015_mm_contactos';
    protected $primaryKey = 'f200_rowid';
    public $timestamps = false;
    //protected $dateFormat = 'Y-m-d';

    public function notas(){
        return $this->hasMany('App\z4_rel_ts_gp', 'cz4_ts_id');
   }

   public function nota(){
    return $this->notas()->where('cz4_gp_id', '7');
}
}
