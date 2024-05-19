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
        Schema::create('comentarios_revisores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idRevisor');
            $table->unsignedInteger('folioSoli'); // Cambiado a unsignedInteger
            $table->text('comentario');
            $table->timestamp('fecha_hora');
            $table->timestamps();

            // Definimos las llaves foráneas
            $table->foreign('idRevisor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('folioSoli')->references('FOLIO_via')->on('solicitudviaticos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios_revisores');
    }
};