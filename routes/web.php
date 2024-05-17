<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    // Retrieve keywords from chat messages
    $keywords = Chat::select(DB::raw('message as name, COUNT(*) as count'))
                    ->groupBy('message')
                    ->get()
                    ->toArray();

    // Retrieve users
    $users = User::all();

    return view('welcome', compact('keywords', 'users'));
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
Route::get('/chats/{user}', [HomeController::class, 'index'])->name('chats.show');
Route::post('/filter-chats', [ChatController::class, 'filterChats'])->name('chats.filter');
