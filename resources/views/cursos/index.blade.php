@extends('layouts.app')

@section('title', 'Lista de Cursos')

@section('content')
    <h2>Lista de Cursos</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla responsiva para mostrar la lista de cursos -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del Curso</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Qr</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Mostrar el número del curso -->
                        <td>{{ $curso->nombre }}</td>
                        <td>{{ $curso->hora_inicio }}</td>
                        <td>{{ $curso->hora_fin }}</td>
                        <td> <!-- Generar el código QR -->
                            <div class="mb-2">
                                {!! QrCode::size(100)->generate(route('registro', ['curso_id' => $curso->id])) !!}
                            </div></td>
                        <td>

                            <!-- Botón para descargar el código QR -->
                            <a href="{{ route('descargar.qr', $curso->id) }}" class="btn btn-primary btn-sm">Descargar Código QR</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
