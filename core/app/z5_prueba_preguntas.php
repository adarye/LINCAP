<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class z5_prueba_preguntas extends Model
{    
    protected $table = 'dbo.z5_prueba_preguntas';
    protected $primaryKey = 'cz5_id';
    public $timestamps = false;

<<<<<<< HEAD
    public function respuestas(){
        return $this->hasMany('App\z7_rta_smur', 'cz7_pp_id');
    }
=======
    public function respuestas()
    {
        return $this->hasMany('App\z7_rta_smur', 'cz7_pp_id');
    }
    public function smmr()
    {
        return $this->hasMany('App\z8_rta_smmr', 'cz8_pp_id');
    }
>>>>>>> 53d491668783f12a86a0fb3f26782ccaba67d472
}

