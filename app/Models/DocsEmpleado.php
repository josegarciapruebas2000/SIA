<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocsEmpleado extends Model
{
    use HasFactory;

    protected $table = 'docsEmpleado';
    protected $primaryKey = 'id_DocsEmp';
    public $timestamps = false; // Si no tienes campos de timestamps (created_at, updated_at)

    protected $fillable = [
        'RFC_emp',
        'CurpDocsEmp',
        'INE_Emp',
        'consFiscal',
        'NSS_Emp',
        'titulo_Emp',
        'cedula_Emp',
        'docComprobatorio_Emp',
        'compDomicilio',
        'actaNacimiento',
        'id_Emp'
    ];

    // Definir la relación con la tabla de Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_Emp');
    }
}
