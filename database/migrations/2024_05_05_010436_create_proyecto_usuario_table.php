<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_usuario', function (Blueprint $table) {
            $table->unsignedBigInteger('idProyecto');
            $table->unsignedBigInteger('idUsuario');
            $table->primary(['idProyecto', 'idUsuario']);

            $table->foreign('idProyecto')->references('idProy')->on('proyectos')->onDelete('cascade');
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_usuario');
    }
};
