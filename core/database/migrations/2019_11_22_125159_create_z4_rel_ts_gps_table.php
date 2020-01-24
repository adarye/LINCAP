<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ4RelTsGpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z4_rel_ts_gps', function (Blueprint $table) {
            $table->bigIncrements('cz4_id');
            $table->bigInteger('cz4_gp_id');
            $table->Integer('cz4_ts_id');
            $table->Integer('cz4_estado');

            $table->foreign('cz4_gp_id')->references('cz3_id')->on('z3_gestion_pruebas')->onDelete('cascade');
            $table->foreign('cz4_ts_id')->references('f200_rowid')->on('dbo.t200_mm_terceros')->onDelete('cascade');
           

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
        Schema::dropIfExists('z4_rel_ts_gps');
    }
}
