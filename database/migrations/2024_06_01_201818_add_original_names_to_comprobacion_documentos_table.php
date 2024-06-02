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
        Schema::table('comprobacion_documentos', function (Blueprint $table) {
            $table->string('original_xml_name')->nullable();
            $table->string('original_pdf_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobacion_documentos', function (Blueprint $table) {
            $table->dropColumn('original_xml_name');
            $table->dropColumn('original_pdf_name');
        });
    }
};
