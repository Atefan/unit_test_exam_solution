<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PhotographerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('photographers', PhotographerController::class);
Route::apiResource('photographers.albums', AlbumController::class);
Route::apiResource('photographers.albums.photos', PhotoController::class);
