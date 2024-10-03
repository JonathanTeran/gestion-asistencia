<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\AsistenciaGeneralController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    // Rutas para crear cursos
    Route::get('/cursos/crear', [CursoController::class, 'crearCursoForm'])->name('cursos.crear');
    Route::post('/cursos', [CursoController::class, 'crearCurso'])->name('cursos.store');
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');
    Route::get('/descargar-qr/{id}', [CursoController::class, 'descargarQr'])->name('descargar.qr');

    // Ruta para escanear y validar asistencia del break (protegida por autenticación)
    Route::get('/break-scanner', [BreakController::class, 'showScanner'])->name('break.scanner');
    Route::get('/', [BreakController::class, 'validarAsistenciaBreak'])->name('validar.asistencia.break');
    Route::post('/validar-asistencia-break', [BreakController::class, 'validarAsistenciaBreak'])->name('validar.asistencia.break');

     // Ruta para escanear y validar asistencia General (protegida por autenticación)
     Route::get('/general-scanner', [AsistenciaGeneralController::class, 'showScanner'])->name('general.scanner');
     Route::get('/', [AsistenciaGeneralController::class, 'validarAsistenciaGeneral'])->name('validar.asistencia.general');
     Route::post('/validar-asistencia-general', [AsistenciaGeneralController::class, 'validarAsistenciaGeneral'])->name('validar.asistencia.general');



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
