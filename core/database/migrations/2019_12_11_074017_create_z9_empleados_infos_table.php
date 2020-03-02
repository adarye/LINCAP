<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ9EmpleadosInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z9_empleados_info', function (Blueprint $table) {
            $table->bigIncrements('cz9_id');
            $table->string('cz9_nombre_familiar')->nullable(true);
            $table->string('cz9_nombre_contacto')->nullable(true);
            $table->string('cz9_tel_contacto')->nullable(true);
            $table->date('cz9_fecha_tpprueba')->nullable(true);
            $table->string('cz9_talla_uniforme')->nullable(true);
            $table->string('cz9_talla_calzado')->nullable(true);
            $table->date('cz9_fecha_vacuna')->nullable(true);
            $table->string('cz9_lugar_vacuna')->nullable(true);
            $table->date('cz9_fecha_vacuna_tifoidea')->nullable(true);
            $table->string('cz9_lugar_vacuna_tifoidea')->nullable(true);
            $table->date('cz9_fecha_vacuna_toxoide')->nullable(true);
            $table->string('cz9_lugar_vacuna_toxoide')->nullable(true);
            $table->string('cz9_reentrenamiento')->nullable(true);
            $table->string('cz9_mail_corp')->nullable(true);
            $table->string('cz9_tel_corp')->nullable(true);
            $table->string('cz9_cel_corp')->nullable(true);
            $table->text('cz9_premios')->nullable(true);

            $table->date('cz9_fv_ta')->nullable(true);
            $table->date('cz9_fv_bpm')->nullable(true);
            $table->date('cz9_fv_md')->nullable(true);
            $table->date('cz9_fv_carne_vacunacion')->nullable(true);
            $table->date('cz9_fv_carne_alimentos')->nullable(true);

            $table->string('cz9_archivo_titulacion')->nullable(true);
            $table->string('cz9_archivo_vacunacion')->nullable(true);



            $table->Integer('cz9_id_empleado');
            $table->foreign('cz9_id_empleado')->references('c0540_rowid_tercero')->on('dbo.w0540_empleados')->onDelete('cascade');
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
        Schema::dropIfExists('z9_empleados_info');
    }
}
