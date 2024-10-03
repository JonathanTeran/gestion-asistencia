<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsistenciaBreak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BreakController extends Controller
{

       // Mostrar la vista del escáner de QR para el break
       public function showScanner()
       {
           return view('break.scanner'); // Asegúrate de tener esta vista creada
       }


    public function validarAsistenciaBreak(Request $request)
    {
        $userId = $request->query('id'); // Captura el 'id' de la URL

        if (!$userId) {
            // Si no hay 'id', puedes redirigir o mostrar un mensaje
            return view('break.scanner'); // O la vista que consideres apropiada
        }

        // Asignar o obtener el 'eventoId'
        //$eventoId = '123'; // Reemplaza con el ID de tu evento actual
        $eventoId = 'f6c017ee-73ba-4b1a-afd5-b5df109c7137';

        // Verificar si ya ha registrado asistencia para el break en este evento
        $asistenciaExistente = AsistenciaBreak::where('userId', $userId)
            ->where('evento_id', $eventoId)
            ->first();

        if ($asistenciaExistente) {
            return view('break.confirmation', [
                'message' => 'Ya has registrado asistencia para el break en este evento.',
                'success' => false
            ]);
        }

        // Consumir la API externa
        $apiUrl = 'https://w0ucj83sp0.execute-api.us-east-1.amazonaws.com/dev/validate';
        $response = Http::post($apiUrl, [
            'action' => 'user_review',
            'userId' => $userId,
            'eventId' => $eventoId,
        ]);

        // Verificar que la respuesta de la API sea exitosa
        if ($response->failed()) {
            return view('break.confirmation', [
                'message' => 'Error al consultar la API externa.',
                'success' => false
            ]);
        }

        // Obtener los datos del usuario desde la respuesta de la API
        $data = $response->json();

        // Verificar si la API devuelve los datos necesarios
        if (!isset($data['userId']) || !isset($data['nombre'])  || !isset($data['email'])) {
            return view('break.confirmation', [
                'message' => 'Respuesta de la API incompleta.',
                'success' => false
            ]);
        }

        // Registrar la asistencia del break
        AsistenciaBreak::create([
            'userId' => $data['userId'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'evento_id' => $eventoId,
            'confirmado' => true,
            'hora_asistencia' => Carbon::now(),
        ]);

        // Retornar una vista de confirmación
        return view('break.confirmation', [
            'message' => 'Asistencia para el break confirmada.',
            'nombre' => $data['nombre'],
            'success' => true
        ]);
    }
}
