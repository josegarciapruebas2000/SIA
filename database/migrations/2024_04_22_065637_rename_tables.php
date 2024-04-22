<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('cliente', 'clientes');
        Schema::rename('proyecto', 'proyectos');
        Schema::rename('empleado', 'empleados');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('clientes', 'cliente');
        Schema::rename('proyectos', 'proyecto');
        Schema::rename('empleados', 'empleado');
    }
}
