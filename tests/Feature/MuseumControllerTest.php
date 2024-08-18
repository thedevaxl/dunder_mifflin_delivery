<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\MuseumRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuseumControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $museumRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->museumRepository = $this->app->make(MuseumRepositoryInterface::class);
    }

    public function test_store_museum_successfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Museo nazionale di Capodimonte',
            'lat' => 40.9458662999999,
            'long' => 14.3715925,
            'region' => 'Campania',
            'province' => 'NA',
            'municipality' => 'Napoli',
        ];

        $response = $this->postJson('/api/museum', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'resource' => $data
                 ]);

        $this->assertDatabaseHas('museums', $data);
    }

    public function test_store_museum_unauthenticated(): void
    {
        $data = [
            'name' => 'Museo nazionale di Capodimonte',
            'lat' => 40.9458662999999,
            'long' => 14.3715925,
            'region' => 'Campania',
            'province' => 'NA',
            'municipality' => 'Napoli',
        ];

        $response = $this->postJson('/api/museum', $data);

        $response->assertStatus(401);
    }

    public function test_store_museum_validation_error(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => '', // Invalid data
            'lat' => 'invalid', // Invalid data
            'long' => 'invalid', // Invalid data
            'region' => '',
            'province' => '',
            'municipality' => '',
        ];

        $response = $this->postJson('/api/museum', $data);

        $response->assertStatus(422);
    }
}
