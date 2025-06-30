<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMuscular extends Model
{
    protected $table = 'grupos_musculares';

    public function ejercicios(){
        return $this->hasMany(Ejercicio::class);
    }

     protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s'
    ];

}
