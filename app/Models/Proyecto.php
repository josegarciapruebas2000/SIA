<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $primaryKey = 'idProy';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idClienteProy', 'idCliente');
    }
}
