<?php

namespace App\Models;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $primaryKey = 'idProy';
    public $timestamps = false;

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idClienteProy', 'idCliente');
    }

    // Relación muchos a muchos con el modelo User
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'proyecto_usuario', 'idProyecto', 'idUsuario');
    }
}
