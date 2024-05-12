<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudViaticos extends Model
{

    protected $table = 'solicitudViaticos'; // Aquí especifica el nombre de tu tabla correctamente

    protected $primaryKey = 'FOLIO_via';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
