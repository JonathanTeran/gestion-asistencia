<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\RegistroController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    // Rutas para crear cursos
    Route::get('/cursos/crear', [CursoController::class, 'crearCursoForm'])->name('cursos.crear');
    Route::post('/cursos', [CursoController::class, 'crearCurso'])->name('cursos.store');
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');
    Route::get('/descargar-qr/{id}', [CursoController::class, 'descargarQr'])->name('descargar.qr');
});

 // Rutas para registrar asistencias
 Route::get('/registro/{curso_id}', [RegistroController::class, 'mostrarFormulario'])->name('registro');
 Route::post('/registro/{curso_id}', [RegistroController::class, 'verificarRegistro'])->name('registro.verificar');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/confirmacion/{curso_id}', function ($cursoId) {
    return view('confirmacion', ['cursoId' => $cursoId]);
})->name('confirmacion');

require __DIR__.'/auth.php';
