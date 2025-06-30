<?php

namespace Tests\Feature;

use App\Models\Ejercicio;
use App\Models\Entrenamiento;
use App\Models\User;
use Database\Seeders\EjercicioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EntrenamientoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_usuario_puede_ver_entrenamiento_con_ejercicios_existentes()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $ejercicio1 = Ejercicio::find(1);
        $ejercicio2 = Ejercicio::find(2);

        $entrenamiento = Entrenamiento::factory()->create([
            'user_id' => $user->id,
        ]);

        $entrenamiento->ejercicios()->attach([
            $ejercicio1->id => ['series' => 3, 'repeticiones' => 12, 'peso' => 20],
            $ejercicio2->id => ['series' => 4, 'repeticiones' => 10, 'peso' => 18],
        ]);

        $response = $this->getJson('/api/v1/entrenamientos');

        $response->assertStatus(200)
            ->assertJsonFragment(['titulo' => $entrenamiento->titulo])
            ->assertJsonFragment(['series' => 3])
            ->assertJsonFragment(['peso' => 20]);
    }
}
