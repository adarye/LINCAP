<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class z7_rta_smur extends Model
{
    protected $table = 'dbo.z7_rta_smurs';
    protected $primaryKey = 'cz7_id';
    public $timestamps = false;

    public function rtas($id){
        $rtas = z7_rta_smurs::where('cz7_pp_id', $id)->get();
        return $rtas;
    }
}
