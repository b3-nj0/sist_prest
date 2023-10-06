<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratos extends Model
{
    use HasFactory;
    protected $primaryKey='contrato_id';
    protected $table='contratos';
    protected $fillable = ['CI_cliente','monto_prestamo','tasa_interes','fecha_inicio','fecha_fin','estado_contrato',];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contrato) {
            $contrato->fecha_inicio = $contrato->fecha_inicio ?: now();
            $contrato->fecha_fin = $contrato->fecha_fin ?: now()->addMonth();
        });
    }

}
