<?php
namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;
use Symfony\Component\HttpFoundation\Response;

class CursoController extends Controller
{
    public function crearCursoForm()
    {
        return view('crear_curso'); // Retorna la vista para crear el curso
    }

    public function index()
    {
        $cursos = Curso::orderBy('hora_inicio', 'asc')->get(); // Obtener todos los cursos de la base de datos
        return view('cursos.index', compact('cursos')); // Retornar la vista con los cursos
    }

    public function crearCurso(Request $request)
    {
        // Validación de los datos del curso
        $request->validate([
            'nombre' => 'required|string|max:255',
            'hora_inicio' => 'required|date',
            'hora_fin' => 'required|date|after:hora_inicio',
        ]);

        // Crear el curso
        Curso::create([
            'nombre' => $request->nombre,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('cursos.index')->with('success', 'Curso creado con éxito.');
    }
    public function descargarQr($id)
    {
        $curso = Curso::findOrFail($id);

        // Crear un nuevo código QR usando endroid/qr-code
        $qrCode = new QrCode(route('registro', ['curso_id' => $curso->id]));
        $qrCode->setSize(250);

        // Configurar la fuente para el label (puedes usar una fuente predeterminada)
        $font = new NotoSans(8); // Tamaño de fuente pequeño (10px)

        // Crear la etiqueta con el horario del curso
        $label = Label::create("Horario: " . $curso->hora_inicio . " - " . $curso->hora_fin)
                      ->setFont($font);

        // Usar el PngWriter para generar el código QR con la etiqueta
        $writer = new PngWriter();
        $result = $writer->write($qrCode, null, $label); // Agregamos el label al QR

        // Obtener los datos binarios del QR generado
        $pngData = $result->getString();

        // Retornar la respuesta con el archivo PNG para descarga
        return new Response($pngData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="curso-'.$curso->id.'-qr.png"',
        ]);
    }
}
