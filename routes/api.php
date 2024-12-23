<?php

use Illuminate\Support\Facades\Route;

Route::post('idea', [\App\Http\Controllers\IdeaController::class, 'create'])->name('idea.create');
