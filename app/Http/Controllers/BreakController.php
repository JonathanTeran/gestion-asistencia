<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsistenciaBreak;
use App\Models\Usuario;
use Carbon\Carbon;

class BreakController extends Controller
{
    // Mostrar la vista del escáner de QR para el break
    public function showScanner()
    {
        return view('break.scanner'); // Asegúrate de tener esta vista creada
    }

    // Validar la asistencia del break
    public function validarAsistenciaBreak(Request $request, $userId)
    {
        // Buscar al usuario por ID
        $usuario = Usuario::find($userId);

        // Verificar si el usuario existe
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        // Verificar si ya ha registrado asistencia para el break en este evento
        $asistenciaExistente = AsistenciaBreak::where('userId', $userId)
                                              ->where('evento_id', $request->eventoId)
                                              ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has registrado asistencia para el break en este evento.'
            ]);
        }

        // Registrar la asistencia del break
        AsistenciaBreak::create([
            'userId' => $userId,
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'email' => $usuario->email,
            'evento_id' => $request->eventoId,
            'confirmado' => true,
            'hora_asistencia' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'nombre' => $usuario->nombre,
            'message' => 'Asistencia para el break confirmada.'
        ]);
    }
}
