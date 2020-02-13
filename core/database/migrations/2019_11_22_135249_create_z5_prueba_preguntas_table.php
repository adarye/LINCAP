<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ5PruebaPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z5_prueba_preguntas', function (Blueprint $table) {
            $table->bigIncrements('cz5_id');
            $table->text('cz5_pregunta');
            $table->string('cz5_categoria');
            $table->bigInteger('cz5_gp_id');
            $table->bigInteger('cz5_n_rtas')->nullable(true);
            $table->bigInteger('cz5_n_rtas_correctas')->nullable(true);

            $table->foreign('cz5_gp_id')->references('cz3_id')->on('z3_gestion_pruebas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('z5_prueba_preguntas');
    }
}
