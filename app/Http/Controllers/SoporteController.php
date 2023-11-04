<?php

namespace App\Http\Controllers;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class SoporteController extends Controller
{
    public function index()
    {
        return view('soporte');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
            'adjuntos.*' => 'file|max:32768', // 32MB como máximo
        ]);

        $remitente = auth()->user()->id;

        // Crea una carpeta para el usuario en public/tickets
        $carpetaUsuario = public_path("tickets/{$remitente}");
        if (!file_exists($carpetaUsuario)) {
            mkdir($carpetaUsuario, 0777, true);
        }

        $archivosAdjuntos = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $archivo) {
                $nombreArchivo = $archivo->getClientOriginalName();
                $rutaArchivo = $archivo->storeAs("tickets/{$remitente}", $nombreArchivo, 'public');
                $archivosAdjuntos[] = $rutaArchivo;
            }
        }

        // Convierte el array de rutas en una cadena separada por comas
        $archivosAdjuntosCadena = implode(',', $archivosAdjuntos);

        Soporte::create([
            'remitente' => $remitente,
            'receptor' => 5, // ID del receptor (ajusta según tus necesidades)
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'adjuntos' => $archivosAdjuntosCadena, // Almacena la cadena en lugar del array
            'tipo' => 'enviado',
        ]);

        return view('soporte')->with('success', 'El ticket se ha enviado correctamente.');
    }

}
    

