<?php

namespace App\Models;

use Database\Factories\PhotographerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photographer extends Model
{
    /** @use HasFactory<PhotographerFactory> */
    use HasFactory;

    protected $fillable = ['name', 'instagram'];

    /**
     * @return HasMany
     */
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
