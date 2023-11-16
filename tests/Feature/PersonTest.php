<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        DB::table('persons')->insert([
                                         'first_name'        => fake()->firstName(),
                                         'last_name'         => fake()->lastName(),
                                         'created_at'        => now(),
                                         'updated_at'        => now(),
                                     ]);
        $person = Person::first();

        $response = $this->post('/api/store', [
            'first_name'        => fake()->firstName(),
            'middle_name'       => rand(0, 1) ? '' : fake()->firstName(),
            'last_name'         => fake()->lastName(),
            'permanent_address' => fake()->address(),
            'temporary_address' => rand(0, 1) ? '' : fake()->address(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/list');
        $response->assertStatus(200);

        $response = $this->get('/api/edit/'.$person->id);
        $response->assertStatus(200);

        $response = $this->post('/api/update/'.$person->id, [
            'first_name'        => fake()->firstName(),
            'last_name'         => fake()->lastName(),
            'permanent_address' => fake()->address(),
            'temporary_address' => rand(0, 1) ? '' : fake()->address(),
            'updated_at'        => now(),
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/destroy/'.$person->id);
        $response->assertStatus(200);
    }
}
