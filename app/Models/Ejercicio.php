<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{

    protected $fillable = ['nombre', 'descripcion', 'categoria_id', 'grupo_muscular_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function grupoMuscular()
    {
        return $this->belongsTo(GrupoMuscular::class);
    }
    public function entrenamientos()
    {
        return $this->belongsToMany(Entrenamiento::class);
    }
    
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s'
    ];
}
