@extends('layouts.app')

@section('title', 'Registro de Asistencia')

@section('content')

<style>
    /* Ajustes adicionales para pantallas pequeñas */
    @media (max-width: 576px) {
        h2 {
            font-size: 1.5rem;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 10px;
        }

        .form-control {
            font-size: 1rem;
        }
    }

    .loading-spinner {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-left-color: #ffffff;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="container my-0">
    <h2 class="text-center">Registro de Asistencia</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif

    <form action="{{ route('registro.verificar', $cursoId) }}" method="POST" class="mt-4" id="asistenciaForm">
        @csrf
        <div class="form-group mb-3">
            <label for="email" class="form-label">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Introduce tu correo" required>
        </div>

        <div class="d-grid">
            <button type="submit" id="submitButton" class="btn btn-primary btn-lg">
                Confirmar Asistencia
            </button>
        </div>
    </form>
    <br>
</div>

<!-- Script para manejar el botón deshabilitado, el loading y volver a habilitar en caso de error -->
<script>
    document.getElementById('asistenciaForm').addEventListener('submit', function(event) {
        var submitButton = document.getElementById('submitButton');

        // Deshabilitar el botón y cambiar el texto
        submitButton.disabled = true;
        submitButton.innerHTML = 'Confirmando... <span class="loading-spinner"></span>';
    });

    // Reactivar el botón si hay un error en la página (lógica para manejar errores del servidor)
    document.addEventListener('DOMContentLoaded', function() {
        var submitButton = document.getElementById('submitButton');

        // Si hay un mensaje de error en la página, volver a habilitar el botón
        if (document.querySelector('.alert-danger')) {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Confirmar Asistencia';
        }

        // Verificar si la página se está cargando desde el historial del navegador
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Habilitar el botón si la página se muestra desde la caché
                submitButton.disabled = false;
                submitButton.innerHTML = 'Confirmar Asistencia';
            }
        });
    });
</script>

@endsection
