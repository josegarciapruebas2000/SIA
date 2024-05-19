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
            $table->string('comentarioRevisor')->nullable();
            $table->string('fechaRevisor')->nullable();
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
            $table->string('comentarioRevisor')->nullable();
            $table->string('fechaRevisor')->nullable();
        });
    }
};
