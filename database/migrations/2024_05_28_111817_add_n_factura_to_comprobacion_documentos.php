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
            $table->bigInteger('idComprobacion')->unsigned()->nullable()->after('idDocumento'); // Agregar columna idComprobacion
            $table->foreign('idComprobacion')->references('idComprobacion')->on('comprobacion_info')->onDelete('cascade');

            $table->string('N_factura', 20)->nullable()->after('idComprobacion'); // Agregar columna N_factura
            $table->decimal('subtotal', 10, 2)->nullable(); // Agregar columna subtotal
            $table->decimal('iva', 10, 2)->nullable(); // Agregar columna IVA
            $table->decimal('total', 10, 2)->nullable(); // Agregar columna total
            $table->string('xml_path')->nullable(); // Agregar columna para el camino del archivo XML
            $table->string('pdf_path')->nullable(); // Agregar columna para el camino del archivo PDF
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
            $table->bigInteger('idComprobacion')->unsigned()->nullable()->after('idDocumento'); // Agregar columna idComprobacion
            $table->foreign('idComprobacion')->references('idComprobacion')->on('comprobacion_info')->onDelete('cascade');

            $table->string('N_factura', 20)->nullable()->after('idDocumento'); // Agregar columna N_factura
            $table->decimal('subtotal', 10, 2)->nullable(); // Agregar columna subtotal
            $table->decimal('iva', 10, 2)->nullable(); // Agregar columna IVA
            $table->decimal('total', 10, 2)->nullable(); // Agregar columna total
            $table->string('xml_path')->nullable(); // Agregar columna para el camino del archivo XML
            $table->string('pdf_path')->nullable(); // Agregar columna para el camino del archivo PDF
        });
    }
};
