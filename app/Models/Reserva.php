<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $fillable = [
        'usuario_id',
        'fecha',
        'cantidad',
        'codigo',
    ];     
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id'); 
    }    
}
