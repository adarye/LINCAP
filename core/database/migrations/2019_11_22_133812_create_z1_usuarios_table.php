<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZ1UsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z1_usuarios', function (Blueprint $table) {
            $table->bigIncrements('cz1_id');
            $table->bigInteger('cz1_cc');
            $table->bigInteger('cz1_contrasena');
            $table->bigInteger('cz1_id_rol');
            $table->Integer('cz1_ts_id');
            $table->string('cz1_avatar');

            $table->foreign('cz1_id_rol')->references('cz2_id')->on('z2_roles')->onDelete('cascade');
            $table->foreign('cz1_ts_id')->references('c0541_rowid')->on('dbo.w0541_terceros_seleccion')->onDelete('cascade');
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
        Schema::dropIfExists('z1_usuarios');
    }
}
