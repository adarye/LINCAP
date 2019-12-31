<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ3GestionPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z3_gestion_pruebas', function (Blueprint $table) {
            $table->bigIncrements('cz3_id');
            $table->string('cz3_nombre');
            $table->string('cz3_categoria');
            $table->string('cz3_descripcion');
            $table->Integer('cz3_id_creador');
            $table->timestamp('cz3_fecha_apertura');
            $table->dateTime('cz3_fecha_cierre');

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('z3_gestion_pruebas');
    }
}
