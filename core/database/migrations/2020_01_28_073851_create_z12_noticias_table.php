<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ12NoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z12_noticias', function (Blueprint $table) {
            $table->bigIncrements('cz12_id');
            $table->Text('cz12_nombre');
            $table->Text('cz12_descripcion');
            $table->Integer('cz12_nivel_imp');
            $table->String('cz12_imagen')->nullable(true);
            $table->String('cz12_archivo')->nullable(true);
            $table->String('cz12_fecha_creacion')->nullable(true);
            $table->Integer('cz12_id_empleado');
            $table->foreign('cz12_id_empleado')->references('c0540_rowid_tercero')->on('dbo.w0540_empleados')->onDelete('cascade');
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
        Schema::dropIfExists('z12_noticias');
    }
}
