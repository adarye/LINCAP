<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ8RtaSmmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z8_rta_smmrs', function (Blueprint $table) {
            $table->bigIncrements('cz8_id');
            $table->bigInteger('cz8_pp_id');
            $table->text('cz8_rta')->nullable(true);
            $table->text('cz8_rta_correcta')->nullable(true);
            $table->foreign('cz8_pp_id')->references('cz5_id')->on('z5_prueba_preguntas')->onDelete('cascade');

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
        Schema::dropIfExists('z8_rta_smmrs');
    }
}
