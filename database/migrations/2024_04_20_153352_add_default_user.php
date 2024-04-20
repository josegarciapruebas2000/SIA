<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Danae',
            'email' => 'danae@gmail.com',
            'role' => 'SuperAdmin',
            'status' => 'true',
            'password' => bcrypt('12345678'),
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
        DB::table('users')->where('email', 'admin@example.com')->delete();
    }
};
