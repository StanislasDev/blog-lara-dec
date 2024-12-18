<?php

use App\Http\Controllers\FooController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FooController::class, 'index'])->name('welcome');
