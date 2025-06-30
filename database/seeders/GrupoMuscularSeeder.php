<?php

namespace Database\Seeders;

use App\Models\GrupoMuscular;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoMuscularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gruposMusculares = [
            'Pecho',
            'Espalda',
            'Hombros',
            'Bíceps',
            'Tríceps',
            'Abdomen',
            'Glúteos',
            'Cuádriceps',
            'Isquiotibiales',
            'Pantorrillas',
            'Antebrazos',
            'Trapecio',
            'Core completo'
        ];

        foreach ($gruposMusculares as $grupoMuscular) {
            GrupoMuscular::create([
                'nombre'=> $grupoMuscular
            ]);
        }
    }
}
