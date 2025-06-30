<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Fuerza',
            'Cardio',
            'Resistencia',
            'Flexibilidad',
            'Equilibrio',
            'Potencia',
            'Movilidad',
            'HIIT',
            'Pliometría',
            'Calistenia'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre' => $categoria
            ]);
        }
    }
}
