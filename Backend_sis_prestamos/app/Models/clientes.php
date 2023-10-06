<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    use HasFactory;
    protected $primaryKey='CI';
    protected $table='clientes';
    protected $fillable = ['nombre','direccion','telefono','calificacion','estado'];
}
