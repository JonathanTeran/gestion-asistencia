@extends('layouts.app')

@section('title', 'Código QR No Válido')

@section('content')
    <div class="container d-flex justify-content-center align-items-center my-0" style="min-height: 70vh;">
        <div class="card text-center shadow-lg p-5" style="border: none; background-color: #f7f7f7; border-radius: 10px;">
            <!-- Ícono de error con mejor visualización -->
            <div class="mb-4">
                <!-- Ícono de flecha hacia atrás (Bootstrap Icon) -->
                <a href="/" class="btn btn-light rounded-circle" style="width: 60px; height: 60px; background-color: #dc3545;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L3.707 7.5H14.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </a>
            </div>

            <!-- Texto de confirmación -->
            <h2 class="display-5 font-weight-bold mb-4 text-danger">El código QR ya no es válido.</h2>
            <p class="lead">Lo sentimos, el horario permitido para este código QR ha terminado.</p>

            <!-- Información del curso (opcional) -->
            <p><strong>Curso:</strong> {{ $curso->nombre }}</p>
            <p><strong>Horario:</strong> De {{ $curso->hora_inicio }} a {{ $curso->hora_fin }}</p>

            <!-- Botón de regreso -->
            <a href="{{ url('/') }}" class="btn btn-danger btn-lg mt-4 px-5">Volver al Inicio</a>
        </div>
    </div>
@endsection
