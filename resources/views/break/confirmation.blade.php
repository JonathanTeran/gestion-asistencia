@extends('layouts.app')

@section('title', 'Confirmación de Asistencia')

@section('content')
<div class="container mt-5 text-center">
    @if($success)
        <h2>{{ $message }}</h2>
        <p>Gracias, {{ $nombre }}.</p>
    @else
        <h2>Error</h2>
        <p>{{ $message }}</p>
    @endif
</div>
@endsection
