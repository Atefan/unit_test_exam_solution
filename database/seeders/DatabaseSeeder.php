<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Photo;
use App\Models\Photographer;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $photographers = Photographer::factory(10)->create();

        $photographers->each(function ($photographer) {
            $albums = Album::factory(5)->create([
                'photographer_id' => $photographer->id,
            ]);

            $albums->each(function ($album) {
                Photo::factory(10)->create([
                    'album_id' => $album->id,
                ]);
            });
        });
    }
}
