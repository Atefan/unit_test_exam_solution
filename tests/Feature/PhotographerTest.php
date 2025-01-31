<?php

namespace Tests\Feature;

use App\Models\Photographer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhotographerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_photographers()
    {
        Photographer::factory()->count(3)->create();

        $response = $this->getJson('/api/photographers');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_a_photographer()
    {
        $data = [
            'name' => 'a',
            'instagram' => 'a',
        ];

        $response = $this->postJson('/api/photographers', $data);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('photographers', ['instagram' => 'a']);
    }

    public function test_can_view_a_single_photographer()
    {
        $photographer = Photographer::factory()->create();

        $response = $this->getJson("/api/photographers/{$photographer->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $photographer->id]);
    }

    public function test_can_update_a_photographer()
    {
        $photographer = Photographer::factory()->create();
        
        $data = ['name' => 'a', 'instagram' => 'a'];
        
        $response = $this->putJson("/api/photographers/{$photographer->id}", $data);
        
        $response->assertStatus(200)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('photographers', ['id' => $photographer->id, 'name' => 'a']);
    }

    public function test_can_delete_a_photographer()
    {
        $photographer = Photographer::factory()->create();

        $response = $this->deleteJson("/api/photographers/{$photographer->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('photographers', ['id' => $photographer->id]);
    }
}
