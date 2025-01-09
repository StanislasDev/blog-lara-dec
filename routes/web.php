<?php

use App\Livewire\Posts;
use App\Livewire\PostShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // auth()->user()->assignRole('admin');
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::get('/admin/posts', Posts::class)->name('posts.index');
});

Route::get('/posts/{slug}', PostShow::class)->name('posts.show');
