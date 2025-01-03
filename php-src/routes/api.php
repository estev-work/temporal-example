<?php

use Illuminate\Support\Facades\Route;

Route::post('idea', [\App\Http\Controllers\IdeaController::class, 'create'])->name('idea.create');
Route::get('idea/{id}', [\App\Http\Controllers\IdeaController::class, 'getById'])->name('idea.create');
