<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class RegistroController extends Controller
{

    public function mostrarFormulario($cursoId)
    {
        $curso = Curso::find($cursoId);
        $horaActual = now();

        // Verificar si la hora actual está dentro del rango permitido
        if ($horaActual->between($curso->hora_inicio, $curso->hora_fin)) {
            return view('registro', compact('cursoId'));
        } else {
            // Si no está dentro del rango, mostrar un mensaje de error o redirigir
            //return redirect()->back()->with('error', 'El código QR ya no es válido para este horario.');
            return view('qr_no_valido', compact('curso'));  // Cargar una vista específica
        }
    }

    public function verificarRegistro(Request $request, $cursoId)
    {
        // Validar el correo ingresado
        $request->validate([
            'email' => 'required|email',
        ]);

        $url = 'https://w0ucj83sp0.execute-api.us-east-1.amazonaws.com/dev/login';
        $eventId = 'f6c017ee-73ba-4b1a-afd5-b5df109c7137';

        // Verificar si el usuario ya ha registrado asistencia para este curso
        $asistenciaExistente = Asistencia::where('curso_id', $cursoId)
                                         ->where('email', $request->email)
                                         ->first();
        if ($asistenciaExistente) {
            return redirect()->back()->with('error', 'Ya has confirmado tu asistencia para este horario.');
        }

        try {
            // Hacer la solicitud inicial sin reintentos para verificar si el usuario existe
            $response = Http::timeout(10) // Aumentar el tiempo límite a 10 segundos
                            ->post($url, [
                                //'action' => 'consult',
                                'email' => $request->email,
                                'eventId' => $eventId,
                            ]);

            // Verificar si la respuesta es 404 (usuario no encontrado)
            if ($response->status() == 404) {
                return redirect()->back()->with('error', 'No se encontró un usuario con el email proporcionado. <a href="https://register.awsugecuador.com/" class="alert-link">Regístrate aquí</a> y vuelve a confirmar tu asistencia.');
            }


            // Si la solicitud inicial falló por otro motivo, aplicar lógica de manejo de error
            if ($response->failed()) {
                // Loguear el error para revisión
                Log::error('Error al conectar con el API', ['response' => $response->body()]);
                return redirect()->back()->with('error', 'No se pudo conectar a la API. Intenta nuevamente más tarde.');
            }

            // Obtener los datos del usuario desde la respuesta
            $data = $response->json();

            // Registrar la asistencia con los datos proporcionados (solo si están disponibles)
            Asistencia::create([
                'curso_id'   => $cursoId,
                'email'      => $data['email'] ?? $request->email, // Guardar email, si no está en la respuesta, se usa el ingresado
                'userId'     => $data['userId'] ?? null,           // Guardar userId si existe
                'nombre'     => $data['nombre'] ?? null,           // Guardar nombre si existe
                'apellido'   => $data['apellido'] ?? null,         // Guardar apellido si existe
                'pass'       => $data['password'] ?? null,         // Guardar la contraseña si existe
                'confirmado' => true,
            ]);

            // Redirigir a la página de confirmación
            return redirect()->route('confirmacion', ['curso_id' => $cursoId])
            ->with('success', 'Asistencia confirmada.')
            ->with('nombre', $data['nombre']);

        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Manejar el error cURL de timeout (cURL error 28)
            if (str_contains($e->getMessage(), 'cURL error 28')) {
                Log::error('Error de timeout en la solicitud HTTP', ['exception' => $e->getMessage()]);
                return redirect()->back()->with('error', 'La solicitud ha tardado demasiado. Intenta nuevamente más tarde.');
            }

            // Capturar cualquier otra excepción de solicitud HTTP
            Log::error('Error en la solicitud HTTP', ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'No se pudo conectar a la API. Intenta nuevamente más tarde.');
        } catch (Exception $e) {
            // Capturar cualquier otra excepción que pueda ocurrir y registrar el error
            Log::error('Error en la verificación de registro', ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Ocurrió un error inesperado. Intenta nuevamente más tarde.');
        }
    }
}
