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
            $table->unsignedInteger('folioSoli')->nullable();  // folioSoli es nuleable
            $table->unsignedBigInteger('folioComprobacion')->nullable();  // folioComprobacion es nuleable y de tipo unsignedBigInteger
            $table->text('comentario');
            $table->timestamp('fecha_hora');
            $table->timestamps();

            // Definimos las claves foráneas
            $table->foreign('idRevisor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('folioSoli')->references('FOLIO_via')->on('solicitudViaticos')->onDelete('cascade');
            $table->foreign('folioComprobacion')->references('idComprobacion')->on('comprobacion_info')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentarios_revisores', function (Blueprint $table) {
            $table->dropForeign(['idRevisor']);
            $table->dropForeign(['folioSoli']);
            $table->dropForeign(['folioComprobacion']);
        });
        Schema::dropIfExists('comentarios_revisores');
    }
};
