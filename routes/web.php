<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('is.admin')->group(function () {
    Route::get('/only-admin', function () {
        return 'El administrador puede ver esto';
    });
});


Route::middleware('is.normal', 'is.admin')->group(function () {
    Route::get('/only-normal', function () {
        return 'El usuario puede ver esto';
    });
});
});



Route::middleware(['auth'])->group(function () {

    Route::resource('tareas', TareaController::class);
});


Route::middleware('auth')->group(function () {

    // Ruta JSON (primero)
    Route::get('/tareas/stats', function () {
        $u = auth()->user();
        return [
            'pendiente'  => $u->tareas()->where('estado','pendiente')->count(),
            'completado' => $u->tareas()->where('estado','completado')->count(),

            'pendientes'  => $u->tareas()
                                ->where('estado', 'pendiente')
                                ->orderByDesc('created_at')
                                ->get(['id', 'titulo']),
        ];
    })->name('tareas.stats');

    //  CRUD
    Route::resource('tareas', TareaController::class)
        ->whereNumber('tarea');
});







require __DIR__.'/auth.php';
