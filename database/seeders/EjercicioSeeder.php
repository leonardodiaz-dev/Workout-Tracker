<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EjercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ejercicios = [
            [
                'nombre' => 'Press de banca',
                'descripcion' => 'Ejercicio de fuerza para el pecho usando barra.',
                'categoria_id' => 1, // Fuerza
                'grupo_muscular_id' => 1, // Pecho
            ],
            [
                'nombre' => 'Sentadilla',
                'descripcion' => 'Ejercicio compuesto para tren inferior.',
                'categoria_id' => 1, // Fuerza
                'grupo_muscular_id' => 8, // Cuádriceps
            ],
            [
                'nombre' => 'Curl de bíceps',
                'descripcion' => 'Flexión del brazo con mancuernas o barra.',
                'categoria_id' => 1, // Fuerza
                'grupo_muscular_id' => 4, // Bíceps
            ],
            [
                'nombre' => 'Plancha abdominal',
                'descripcion' => 'Ejercicio isométrico para fortalecer el core.',
                'categoria_id' => 3, // Resistencia
                'grupo_muscular_id' => 6, // Abdomen
            ],
            [
                'nombre' => 'Trote en cinta',
                'descripcion' => 'Ejercicio cardiovascular de bajo impacto.',
                'categoria_id' => 2, // Cardio
                'grupo_muscular_id' => 8, // Cuádriceps (piernas en general)
            ],
            [
                'nombre' => 'Remo con barra',
                'descripcion' => 'Fortalece la espalda media y baja.',
                'categoria_id' => 1,
                'grupo_muscular_id' => 2, // Espalda
            ],
            [
                'nombre' => 'Elevaciones laterales',
                'descripcion' => 'Aislamiento de los deltoides laterales.',
                'categoria_id' => 1,
                'grupo_muscular_id' => 3, // Hombros
            ],
            [
                'nombre' => 'Burpees',
                'descripcion' => 'Ejercicio funcional de cuerpo completo.',
                'categoria_id' => 8, // HIIT
                'grupo_muscular_id' => 13, // Core completo
            ],
        ];

          foreach ($ejercicios as $ejercicio) {
            Ejercicio::create($ejercicio);
        }
    }
}
