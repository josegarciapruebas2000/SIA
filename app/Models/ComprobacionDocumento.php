<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobacionDocumento extends Model
{
    use HasFactory;

    protected $table = 'comprobacion_documentos';

    protected $primaryKey = 'idDocumento';

    public $timestamps = false;

    protected $fillable = [
        'idComprobacion', 'fecha_subida', 'descripcion',
        'N_factura', 'subtotal', 'iva', 'total',
        'xml_path', 'pdf_path'
    ];
}
