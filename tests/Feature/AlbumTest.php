<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photographer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_albums_of_photographer()
    {
        $photographer = Photographer::factory()->create();
        Album::factory()->count(3)->create(['photographer_id' => $photographer->id]);

        $response = $this->getJson("/api/photographers/{$photographer->id}/albums");

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_an_album()
    {
        $photographer = Photographer::factory()->create();
        $data = ['name' => 'a'];

        $response = $this->postJson("/api/photographers/{$photographer->id}/albums", $data);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('albums', ['name' => 'a', 'photographer_id' => $photographer->id]);
    }

    public function test_can_view_a_single_album()
    {
        $album = Album::factory()->create();

        $response = $this->getJson("/api/photographers/{$album->photographer_id}/albums/{$album->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $album->id]);
    }

    public function test_can_update_an_album()
    {
        $album = Album::factory()->create();
        $data = ['name' => 'a'];

        $response = $this->putJson("/api/photographers/{$album->photographer_id}/albums/{$album->id}", $data);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('albums', ['id' => $album->id, 'name' => 'a']);
    }

    public function test_can_delete_an_album()
    {
        $album = Album::factory()->create();

        $response = $this->deleteJson("/api/photographers/{$album->photographer_id}/albums/{$album->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }
}