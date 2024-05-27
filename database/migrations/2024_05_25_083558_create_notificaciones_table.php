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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('mensaje');
            $table->boolean('leida')->default(false);
            $table->string('nivel', 255); // Mismo tipo y longitud que en la tabla users
            $table->unsignedInteger('folio_via'); // Cambiado a un tipo numérico compatible
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
        Schema::dropIfExists('notificaciones');
    }
};
