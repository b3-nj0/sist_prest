<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingresos_egresos extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $table='ingresos_egresos';
    protected $fillable = ['ingreso','egreso','amortizaciones_id','Renovacion_id'];
}