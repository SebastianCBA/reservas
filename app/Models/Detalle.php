<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;
    protected $fillable = [
        'reserva_id',
        'fila',
        'columna',
    ];     
    public function reserva() {
        return $this->belongsTo(Reserva::class, 'reserva_id'); 
    }    
}
