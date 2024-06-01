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
        Schema::table('solicitudviaticos', function (Blueprint $table) {
            Schema::table('solicitudviaticos', function (Blueprint $table) {
                $table->boolean('aceptadoNivel1')->default(false);
                $table->boolean('aceptadoNivel2')->default(false);
                $table->boolean('aceptadoNivel3')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudviaticos', function (Blueprint $table) {
            $table->boolean('aceptadoNivel1')->default(false);
            $table->boolean('aceptadoNivel2')->default(false);
            $table->boolean('aceptadoNivel3')->default(false);
        });
    }
};
