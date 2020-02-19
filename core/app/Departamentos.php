<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = 'dbo.t012_mm_deptos';
    protected $primaryKey = 'f012_id';

    public function ciudades(){
        return $this->hasMany('App\Ciudades');
   }
   
   public function paises(){
        return $this->belongsTo('App\Paises');
   }
}
