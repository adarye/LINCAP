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
            $table->string('password');
            $table->rememberToken();
            $table->string('cz1_nombres');
            $table->bigInteger('cz1_id_rol');
            $table->Integer('cz1_id_empleado');
            $table->Integer('cz1_estado');
            $table->string('cz1_avatar');

            $table->foreign('cz1_id_rol')->references('cz2_id')->on('z2_roles')->onDelete('cascade');
            $table->foreign('cz1_id_empleado')->references('c0540_rowid_tercero')->on('dbo.w0540_empleados')->onDelete('cascade');
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
