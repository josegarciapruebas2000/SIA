<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudViaticos extends Model
{
    use HasFactory;

    protected $table = 'solicitudviaticos'; // Asegúrate de que el nombre de la tabla sea correcto
    protected $primaryKey = 'FOLIO_via';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'idProy_via', 'idProy');
    }

    public function revisor()
    {
        return $this->belongsTo(User::class, 'revisor_id');
    }

    public function comprobaciones()
{
    return $this->hasMany('App\Models\ComprobacionInfo', 'folio_via', 'FOLIO_via');
}
}
