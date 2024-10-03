@extends('layouts.app')

@section('title', 'Confirmación de Asistencia')

@section('content')
    <div class="container d-flex justify-content-center my-0" style="min-height: 50vh;">
        <div class="card text-center shadow-lg p-5" style="border: none; background-color: #f7f7f7; border-radius: 10px;">
            <!-- Ícono de confirmación -->
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM12.146 5.354a.5.5 0 0 0-.707 0L7 9.793 4.854 7.646a.5.5 0 1 0-.708.708l2.5 2.5a.5.5 0 0 0 .707 0l5-5a.5.5 0 0 0 0-.707z"/>
                </svg>
            </div>

            <!-- Texto de confirmación -->
            <h2 class="display-4 font-weight-bold mb-4" style="color: #28a745;">¡Asistencia Confirmada!</h2>
            <p class="lead">

                {{ session('nombre') ? 'Hola ' . trim(session('nombre')).', ' : '' }}Tu asistencia a la charla ha sido confirmada.</p>

            <!-- Botón de regreso -->
            <a href="/" class="btn btn-primary btn-lg mt-4 px-5">Volver al Inicio</a>
        </div>
    </div>
    <br>

    <!-- Incluir la librería Confetti.js desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <script>
        // Función para lanzar el confeti
        function lanzarConfeti() {
            let duration = 5 * 1000; // Duración en milisegundos (5 segundos)
            let end = Date.now() + duration;

            // Crear una animación continua de confeti
            (function frame() {
                // Configurar el confeti
                confetti({
                    particleCount: 3,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 }
                });
                confetti({
                    particleCount: 3,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 }
                });

                // Continuar la animación hasta que pase el tiempo especificado
                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        }
        // Iniciar el confeti al cargar la página
        document.addEventListener('DOMContentLoaded', lanzarConfeti);
    </script>
@endsection
