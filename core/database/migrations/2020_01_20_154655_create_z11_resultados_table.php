<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ11ResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z11_resultados', function (Blueprint $table) {
            $table->bigIncrements('cz11_id');
            $table->bigInteger('cz11_id_gp');
            $table->Integer('cz11_id_empleado');
            $table->bigInteger('cz11_pp_id');
            $table->text('cz11_categoria');
            $table->float('cz11_nota')->nullable(true);
            $table->text('cz11_rta_ra')->nullable(true);
            $table->bigInteger('cz11_rta')->nullable(true);;
            $table->timestamps();

            $table->foreign('cz11_id_gp')->references('cz3_id')->on('z3_gestion_pruebas')->onDelete('cascade');
            $table->foreign('cz11_id_empleado')->references('c0540_rowid_tercero')->on('w0540_empleados')->onDelete('cascade');
            // $table->foreign('cz11_pp_id')->references('cz5_id')->on('z5_prueba_preguntas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('z11_resultados');
    }
}
