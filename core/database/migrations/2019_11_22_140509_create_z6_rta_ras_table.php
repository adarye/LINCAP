<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ6RtaRasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z6_rta_ras', function (Blueprint $table) {
            $table->bigIncrements('cz6_id');
            $table->bigInteger('cz6_pp_id');
            $table->text('cz6_rta');

            $table->foreign('cz6_pp_id')->references('cz5_id')->on('z5_prueba_preguntas')->onDelete('cascade');

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
        Schema::dropIfExists('z6_rta_ras');
    }
}
