<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $table = 'clientes';

    protected $fillable = ['nombre', 'categoriaCliente', 'status'];

    public $timestamps = false;

    protected $primaryKey = 'idCliente'; // Especifica el nombre de la clave primaria

    protected $keyType = 'int'; // Especifica el tipo de la clave primaria

    // También puedes especificar si la clave primaria es autoincremental o no
    // protected $incrementing = false; // Por defecto es true si la clave primaria es de tipo entero



}
