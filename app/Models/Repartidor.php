<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    protected $table = 'repartidores';
    protected $fillable = ['nombre', 'telefono', 'placa_vehiculo', 'activo'];
    public function orders()
    {
        return $this->hasMany(Order::class, 'repartidor_id');
    }
}
