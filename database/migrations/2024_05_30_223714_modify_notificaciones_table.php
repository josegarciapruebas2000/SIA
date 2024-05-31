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
        Schema::table('notificaciones', function (Blueprint $table) {
            $table->string('id_User')->nullable()->after('nivel'); // Asegúrate de cambiar la posición si es necesario
            $table->string('nivel', 255)->nullable()->change(); // Laravel requiere la instalación de doctrine/dbal para cambiar columnas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificaciones', function (Blueprint $table) {
            $table->dropColumn('id_User');
            $table->string('nivel', 255)->nullable(false)->change(); // Restaura la no aceptación de nulos
        });
    }
};
