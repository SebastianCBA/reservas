<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombres',
        'apellidos',
    ];    
    public function reservas() {
       return $this->hasMany(Reserva::class); 
    }    
}
