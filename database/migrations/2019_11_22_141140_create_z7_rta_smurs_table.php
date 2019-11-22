<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ7RtaSmursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z7_rta_smurs', function (Blueprint $table) {
            $table->bigIncrements('cz7_id');
            $table->bigInteger('cz7_pp_id');
            $table->text('cz7_rta');
            $table->text('cz7_rta_correcta');
            
            $table->foreign('cz7_pp_id')->references('cz5_id')->on('z5_prueba_preguntas')->onDelete('cascade');

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
        Schema::dropIfExists('z7_rta_smurs');
    }
}
