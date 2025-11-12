<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;



Route::prefix('tareas')->group(function () {
    Route::get('/', [TareaController::class, 'indexApi']);
    Route::post('/', [TareaController::class, 'storeApi']);
    Route::get('/{tarea}', [TareaController::class, 'showApi']);
    Route::put('/{tarea}', [TareaController::class, 'updateApi']);
    Route::delete('/{tarea}', [TareaController::class, 'destroyApi']);
});
