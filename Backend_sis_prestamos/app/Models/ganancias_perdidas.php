<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ganancias_perdidas extends Model
{
    use HasFactory;
    protected $primaryKey='ganancias_id';
    protected $table='ganancias_perdidas';
    protected $fillable = ['monto_ganancias','monto_perdida','capital','id'];
}