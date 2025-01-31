<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photo;
use App\Models\Photographer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_photos_in_an_album()
    {
        $album = Album::factory()->create();
        Photo::factory()->count(3)->create(['album_id' => $album->id]);

        $response = $this->getJson("/api/photographers/{$album->photographer_id}/albums/{$album->id}/photos");

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_a_photo()
    {
        $album = Album::factory()->create();
        $data = ['name' => 'a'];

        $response = $this->postJson("/api/photographers/{$album->photographer_id}/albums/{$album->id}/photos", $data);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('photos', ['name' => 'a', 'album_id' => $album->id]);
    }

    public function test_can_view_a_single_photo()
    {
        $photo = Photo::factory()->create();

        $response = $this->getJson("/api/photographers/{$photo->album->photographer_id}/albums/{$photo->album_id}/photos/{$photo->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $photo->id]);
    }

    public function test_can_update_a_photo()
    {
        $photo = Photo::factory()->create();
        $data = ['name' => 'a'];

        $response = $this->putJson("/api/photographers/{$photo->album->photographer_id}/albums/{$photo->album_id}/photos/{$photo->id}", $data);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'a']);
        $this->assertDatabaseHas('photos', ['id' => $photo->id, 'name' => 'a']);
    }

    public function test_can_delete_a_photo()
    {
        $photo = Photo::factory()->create();

        $response = $this->deleteJson("/api/photographers/{$photo->album->photographer_id}/albums/{$photo->album_id}/photos/{$photo->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
    }
}
