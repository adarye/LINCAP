<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    protected $table = 'dbo.t011_mm_paises';
    protected $primaryKey = 'f011_id';

    public function departamentos()
    {
        return $this->hasMany('App\Departamentos', 'f012_id_pais');
    }
    public function depAndCiudades()
    {
        return $this->departamentos->with('ciudades');
    }
}
