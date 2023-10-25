<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharactersController;

use Illuminate\Support\Facades\Http;

// Nous ajoutons l'URL pour tester

Route::get('/test-api', function () {
    $response = Http::get('https://rickandmortyapi.com/api/character');
    return $response->json();
});

Route::get('/api/character', [CharactersController::class, 'yourMethodName']);


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CharactersController::class, 'index'])->name('characters');
