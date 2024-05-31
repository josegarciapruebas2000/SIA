<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'titulo',
        'mensaje',
        'leida',
        'nivel',
        'folio_via',
        'id_User',
    ];

    /**
     * Obtener el usuario asociado con la notificación.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
