<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Museum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Repositories\MuseumRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function test_import_museums_successfully(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');


        // Fake the storage
        Storage::fake('local');

        // Create a fake JSON file
        $file = UploadedFile::fake()->createWithContent(
            'museums.json',
            json_encode([
                [
                    "ccomune" => "ALTRO",
                    "cprovincia" => "ALTRO",
                    "cregione" => "ALTRO",
                    "cnome" => "Museo Test",
                    "clatitudine" => "45.123456",
                    "clongitudine" => "12.123456"
                ]
            ])
        );

        // Perform the request with the file
        $response = $this->postJson('/api/museums/import', [
            'file' => $file,
        ]);

        // Assert the response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Museums imported successfully.'
            ]);

        // Check if the data is in the database
        $this->assertDatabaseHas('museums', [
            'municipality' => 'ALTRO',
            'province' => 'ALTRO',
            'region' => 'ALTRO',
            'name' => 'Museo Test',
            'latitude' => '45.123456',
            'longitude' => '12.123456',
        ]);
    }
    public function test_import_museums_validation_error(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Perform the request without uploading a file
        $response = $this->postJson('/api/museums/import', [
            'file' => 'not-a-file',
        ]);

        // Assert the response status and validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['file']);
    }
    public function test_import_museums_with_empty_file(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Fake the storage
        Storage::fake('local');

        // Create an empty JSON file
        $file = UploadedFile::fake()->createWithContent('empty_museums.json', '');

        // Perform the request with the empty file
        $response = $this->postJson('/api/museums/import', [
            'file' => $file,
        ]);

        // Assert the response status and structure
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The uploaded file is empty.',
            ]);
    }

    public function test_import_museums_without_file(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Perform the request without uploading a file
        $response = $this->postJson('/api/museums/import');

        // Assert the response status and validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['file']);
    }
    public function test_import_museums_authentication_error(): void
    {
        // Perform the request without uploading a file
        $response = $this->postJson('/api/museums/import', [
        ]);

        // Assert the response status
        $response->assertStatus(401);
    }

}
