@extends('layouts.app')

@section('content')
    <h2>Crear Curso</h2>

    <form action="{{ route('cursos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Curso:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="hora_inicio">Hora de Inicio:</label>
            <input type="datetime-local" name="hora_inicio" id="hora_inicio" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="hora_fin">Hora de Fin:</label>
            <input type="datetime-local" name="hora_fin" id="hora_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Curso</button>
    </form>
@endsection
