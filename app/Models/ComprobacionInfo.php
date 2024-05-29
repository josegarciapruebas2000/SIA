<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobacionInfo extends Model
{
    use HasFactory;

    protected $table = 'comprobacion_info';
    protected $primaryKey = 'idComprobacion';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'folio_via', 'monto_comprobado', 'nivel',
        'aceptadoNivel1', 'aceptadoNivel2', 'aceptadoNivel3'
    ];

    // Relación con ComprobacionDocumento
    public function documentos()
    {
        return $this->hasMany(ComprobacionDocumento::class, 'idComprobacion');
    }

    public function solicitudViatico()
    {
        return $this->belongsTo('App\Models\SolicitudViaticos', 'folio_via', 'FOLIO_via');
    }
}
