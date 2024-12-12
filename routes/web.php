<?php

use Illuminate\Foundation\Application;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


// Rutas para las notas
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index'); // Listar todas las notas
Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create'); // Formulario para crear una nota
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store'); // Guardar una nueva nota
Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit'); // Formulario para editar una nota
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update'); // Actualizar una nota
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy'); // Eliminar una nota

Route::get('/notes/{id}/pdf', [NoteController::class, 'generatePdf'])->name('notes.pdf');