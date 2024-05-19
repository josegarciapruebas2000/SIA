<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioRevisor extends Model
{
    use HasFactory;

    protected $table = 'comentarios_revisores';

    protected $fillable = [
        'idRevisor',
        'folioSoli',
        'comentario',
        'fecha_hora',
    ];

    public function revisor()
{
    return $this->belongsTo(User::class, 'idRevisor');
}
}
