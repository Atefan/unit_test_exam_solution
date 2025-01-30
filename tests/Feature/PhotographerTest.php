<?php

use App\Models\Photographer;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

test('can list all photographers', function () {
    Photographer::factory()->count(3)->create();

    $response = $this->getJson('/api/photographers');

    $response->assertStatus(200)->assertJsonCount(3);
})->group('photographers');

test('can create a photographer', function () {
    $data = [
        'name' => 'A',
        'email' => 'a@a.com',
        'bio' => 'Bio',
        'instagram' => 'instagram_handle',
    ];

    $response = $this->postJson('/api/photographers', $data);

    $response->assertStatus(201)
    ->assertJsonFragment(['name' => 'A']);

    $this->assertDatabaseHas('photographers', ['email' => 'a@a.com']);
})->group('photographers');

test('can view a single photographer', function () {
    $photographer = Photographer::factory()->create(['name' => 'A']);

    $response = $this->getJson("/api/photographers/{$photographer->id}");

    $response->assertStatus(200)->assertJson(['id' => $photographer->id, 'name' => 'A']);
})->group('photographers');

test('can update a photographer', function () {
    $photographer = Photographer::factory()->create(['name' => 'A']);
    $updatedData = ['name' => 'A', 'instagram' => 'a'];

    $response = $this->putJson("/api/photographers/{$photographer->id}", $updatedData);

    $response->assertStatus(200)->assertJson(['name' => 'A']);
    $this->assertDatabaseHas('photographers', ['name' => 'A']);
})->group('photographers');

test('can delete a photographer', function () {
    $photographer = Photographer::factory()->create();

    $response = $this->deleteJson("/api/photographers/{$photographer->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('photographers', ['id' => $photographer->id]);
})->group('photographers');

test('can list albums of a photographer', function () {
    $photographer = Photographer::factory()->create();
    Album::factory()->create(['photographer_id' => $photographer->id]);
    Album::factory()->create(['photographer_id' => $photographer->id]);

    $response = $this->getJson("/api/photographers/{$photographer->id}/albums");

    $response->assertStatus(200)->assertJsonCount(2);
})->group('photographers');

test('can list photos in an album', function () {
    $photographer = Photographer::factory()->create();
    $album = Album::factory()->create([ 'photographer_id' => $photographer->id]);

    Photo::factory()->create(['album_id' => $album->id]);
    Photo::factory()->create(['album_id' => $album->id]);

    $response = $this->getJson("/api/photographers/{$photographer->id}/albums/{$album->id}/photos");

    $response->assertStatus(200)->assertJsonCount(2);
})->group('photographers');

test('can delete a photo', function () {
    $photographer = Photographer::factory()->create();
    $album = Album::factory()->create(['photographer_id' => $photographer->id]);
    $photo = Photo::factory()->create(['album_id' => $album->id]);

    $response = $this->deleteJson("/api/photographers/{$photographer->id}/albums/{$album->id}/photos/{$photo->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
})->group('photographers');
