<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'super.admin@ajeb.com.mx ',
            'role' => 'SuperAdmin',
            'status' => true,
            'password' => bcrypt('202425@AjebCCS!'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar el usuario por defecto si se revierte la migración
        DB::table('users')->where('email', 'danae@gmail.com')->delete();
    }
};
