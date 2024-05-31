<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioRevisor extends Model
{
    use HasFactory;

    protected $table = 'comentarios_revisores';

    protected $dates = ['fecha_hora', 'created_at', 'updated_at'];


    protected $fillable = [
        'idRevisor',
        'folioSoli',
        'folioComprobacion',
        'comentario',
        'fecha_hora',        
    ];

    public function revisor()
    {
        return $this->belongsTo(User::class, 'idRevisor');
    }
}
