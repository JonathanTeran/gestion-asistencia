@extends('layouts.app')

@section('title', 'Lista de Cursos')

@section('content')
    {{--  <h2>Lista de Cursos</h2>  --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla para mostrar la lista de cursos -->
    {{--  <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre del Curso</th>
                <th>Hora de Inicio</th>
                <th>Hora de Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>  --}}
@endsection
