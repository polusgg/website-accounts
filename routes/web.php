<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('dashboard'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('discord/redirect', [DiscordController::class, 'redirectToProvider'])->name('discord.connect');
Route::get('discord/callback', [DiscordController::class, 'handleProviderCallback']);
Route::get('discord/join', [DiscordController::class, 'joinServer'])->name('discord.join');
