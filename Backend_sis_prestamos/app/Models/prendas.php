<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prendas extends Model
{
    use HasFactory;
    protected $primaryKey='prenda_id';
    protected $table='prendas';
    protected $fillable = ['contrato_id','valor_prenda','descripcion','estado'];
}