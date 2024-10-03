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
           $userId = $request->input('id'); // Obtener el 'id' de la petición AJAX

           if (!$userId) {
               return response()->json([
                   'success' => false,
                   'message' => 'ID de usuario no proporcionado.'
               ], 400);
           }

           // Asignar el 'eventoId' (modifica según tus necesidades)
           $eventoId = 'f6c017ee-73ba-4b1a-afd5-b5df109c7137';

           // Verificar si ya ha registrado asistencia para el break en este evento
           $asistenciaExistente = AsistenciaBreak::where('userId', $userId)
               ->where('evento_id', $eventoId)
               ->first();

           if ($asistenciaExistente) {
               return response()->json([
                   'success' => false,
                   'message' => 'Ya has registrado asistencia para el break en este evento.',
                   'nombre' => $asistenciaExistente->nombre
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
               return response()->json([
                   'success' => false,
                   'message' => 'Error al consultar la API externa.'
               ], $response->status());
           }

           // Obtener los datos del usuario desde la respuesta de la API
           $data = $response->json();

           // Verificar si la API devuelve los datos necesarios
           if (!isset($data['userId']) || !isset($data['nombre']) || !isset($data['email'])) {
               return response()->json([
                   'success' => false,
                   'message' => 'Respuesta de la API incompleta.'
               ], 400);
           }

           // Registrar la asistencia del break
           AsistenciaBreak::create([
               'userId' => $data['userId'],
               'nombre' => $data['nombre'],
               'apellido' => $data['apellido'] ?? '',
               'email' => $data['email'],
               'evento_id' => $eventoId,
               'confirmado' => true,
               'hora_asistencia' => Carbon::now(),
           ]);

           return response()->json([
               'success' => true,
               'message' => 'Asistencia para el break confirmada.',
               'nombre' => $data['nombre']
           ]);
       }



       public function validarAsistenciaBreak2(Request $request)
    {
        $userId = $request->input('id'); // Obtener el 'id' de la petición AJAX

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario no proporcionado.'
            ], 400);
        }

        // Asignar el 'eventoId' (puedes modificarlo según tus necesidades)
        $eventoId = 'f6c017ee-73ba-4b1a-afd5-b5df109c7137'; // Reemplaza con el ID de tu evento actual

        // Verificar si ya ha registrado asistencia para el break en este evento
        $asistenciaExistente = AsistenciaBreak::where('userId', $userId)
            ->where('evento_id', $eventoId)
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has registrado asistencia para el break en este evento, No puede tomar Break'
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
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar la API externa.'
            ], $response->status());
        }

        // Obtener los datos del usuario desde la respuesta de la API
        $data = $response->json();

        // Verificar si la API devuelve los datos necesarios
        if (!isset($data['userId']) || !isset($data['nombre']) || !isset($data['email'])) {
            return response()->json([
                'success' => false,
                'message' => 'Respuesta de la API incompleta.'
            ], 400);
        }

        // Registrar la asistencia del break
        AsistenciaBreak::create([
            'userId' => $data['userId'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'] ?? '',
            'email' => $data['email'],
            'evento_id' => $eventoId,
            'confirmado' => true,
            'hora_asistencia' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia para el break confirmada, puede servirse.',
            'nombre' => $data['nombre']
        ]);
    }


}
