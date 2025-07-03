<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Livewire\Chat;
use App\Http\Controllers\ChatController;


// -------------------------------
// View Route for Main Chat Page
// -------------------------------
Route::get('/', function () {
    return view('livewire.chat');
})->name('chat');

// ----------------------------------------
// RESTful Chat API Routes (via web.php)
// ----------------------------------------

Route::get('/chats', [ChatController::class, 'index']);
Route::post('/chats', [ChatController::class, 'store']);
Route::post('/chats/{chat}/messages', [ChatController::class, 'storeMessage']);
Route::delete('/chats/{chat}', [ChatController::class, 'destroy']);
Route::put('/chats/{chat}', [ChatController::class, 'update']);





//Other file routes connection 


Route::get('/webchat', function () {
    return view('livewire.webchat');
})->name('webchat');

Route::get('/chatbot', function () {
    return view('livewire.chatbot');
})->name('chatbot');

Route::get('/chattest', function () {
    return view('livewire.chattest');
})->name('chattest');

Route::get('/nchat', function () {
    return view('livewire.nchat');
})->name('nchat');

Route::get('/txt', function () {
    return view('livewire.txt');
})->name('txt');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
