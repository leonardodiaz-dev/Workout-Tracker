<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'status', 'fecha_programacion', 'comentario', 'user_id'];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class)
            ->withPivot('id','series', 'repeticiones', 'peso')
            ->as('detalle')
            ->withTimestamps();
    }
}
