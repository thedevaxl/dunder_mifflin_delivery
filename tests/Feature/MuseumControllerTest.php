<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Museum;
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

    // Store Museum Tests
    public function test_store_museum_successfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Museo nazionale di Capodimonte',
            'latitude' => 40.9458662999999,
            'longitude' => 14.3715925,
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
            'latitude' => 40.9458662999999,
            'longitude' => 14.3715925,
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
            'latitude' => 'invalid', // Invalid data
            'longitude' => 'invalid', // Invalid data
            'region' => '',
            'province' => '',
            'municipality' => '',
        ];

        $response = $this->postJson('/api/museum', $data);

        $response->assertStatus(422);
    }

    // Search Museum Tests
    public function test_search_museums_successfully(): void
    {
        // No authentication needed for this test
        Museum::factory()->create([
            'name' => 'Museo nazionale di Capodimonte',
            'latitude' => 40.9458662999999,
            'longitude' => 14.3715925,
            'region' => 'Campania',
            'province' => 'NA',
            'municipality' => 'Napoli',
        ]);

        Museum::factory()->create([
            'name' => 'MUSA - Sezione di Farmacologia',
            'latitude' => 40.8551785,
            'longitude' => 14.2566472999999,
            'region' => 'Campania',
            'province' => 'NA',
            'municipality' => 'Napoli',
        ]);

        $response = $this->getJson('/api/museum?m=Napoli&latitude=40.8672819&longitude=14.2507827&r=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'latitude',
                    'longitude',
                    'region',
                    'province',
                    'municipality',
                    'distance'
                ]
            ])
            ->assertJsonFragment([
                'municipality' => 'Napoli',
            ]);
    }

    public function test_search_museums_without_radius(): void
    {
        // No authentication needed for this test
        Museum::factory()->create([
            'name' => 'Museo nazionale di Capodimonte',
            'latitude' => 40.9458662999999,
            'longitude' => 14.3715925,
            'region' => 'Campania',
            'province' => 'NA',
            'municipality' => 'Napoli',
        ]);

        $response = $this->getJson('/api/museum?m=Napoli&latitude=40.8672819&longitude=14.2507827');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'latitude',
                    'longitude',
                    'region',
                    'province',
                    'municipality',
                    'distance'
                ]
            ])
            ->assertJsonFragment([
                'municipality' => 'Napoli',
            ]);
    }

    public function test_search_museums_validation_error(): void
    {
        // No authentication needed for this test
        $response = $this->getJson('/api/museum?m=&latitude=&longitude=');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['m', 'latitude', 'longitude']);
    }

    public function test_list_all_museums(): void
    {
        // Create multiple museums
        Museum::factory()->count(3)->create();

        $response = $this->getJson('/api/museums');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'latitude',
                    'longitude',
                    'region',
                    'province',
                    'municipality',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

}
