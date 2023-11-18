<?php

namespace App\Http\Controllers;

use App\Models\Soporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;

class SoporteController extends Controller

{

    public function showSoporteForm(Request $request)
    {
        $totalRecibidos = Soporte::countRecibidos(auth()->id());
        $totalEnviados = Soporte::countEnviados(auth()->id());
        $totalPapelera = Soporte::countPapelera(auth()->id());

        // Inicializa la variable $users como un array vacío
        $users = [];

        // Verifica si el usuario autenticado tiene el rol de 'admin'
        if (auth()->user()->role === 'admin') {
            // Obtén la lista de usuarios para el admin
            $users = User::where('role', 'user')->get();
        }

        // Si se proporciona un ID de ticket para responder o reenviar, carga la información del ticket
        $responderId = $request->input('responder_id');
        $reenviarId = $request->input('reenviar_id');
        $ticket = null;

        if ($responderId) {
            $ticket = Soporte::find($responderId);

            // Agregar "RESP:" al principio del asunto
            $ticket->asunto = "RESP: " . $ticket->asunto;
        } elseif ($reenviarId) {
            $ticket = Soporte::find($reenviarId);

            // Agregar "REEN:" al principio del asunto
            $ticket->asunto = "REEN: " . $ticket->asunto;
        }

        // Agregar lógica para limpiar el ticket si no se presionó ninguno de los botones de respuesta
        if (!$responderId && !$reenviarId) {
            $ticket = null;
        }

        return view('soporte', compact('totalRecibidos', 'totalEnviados', 'totalPapelera', 'users', 'ticket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receptor' => 'required|integer',
            'asunto' => 'required',
            'mensaje' => 'required',
            'adjuntos.*' => 'nullable|max:32000', // Cambiado de 'required' a 'nullable'
        ]);

        // Obtener el ID del usuario autenticado como remitente
        $remitenteId = auth()->id();

        // Almacenar rutas de archivos en un array
        $archivos = [];

        // Verificar si hay archivos adjuntos antes de procesarlos
        if ($request->hasFile('adjuntos')) {
            // Procesar cada archivo adjunto
            foreach ($request->file('adjuntos') as $adjunto) {
                // Generar un nombre único para cada archivo
                $nombreArchivo = uniqid() . '_' . $adjunto->getClientOriginalName();

                // Crear una carpeta para cada usuario dentro de 'public/tickets'
                $userFolder = "public/tickets/{$remitenteId}";

                if (!Storage::exists($userFolder)) {
                    Storage::makeDirectory($userFolder);
                }

                // Almacenar archivos en la carpeta del usuario
                $adjuntosPath = $adjunto->storeAs($userFolder, $nombreArchivo);

                // Agregar ruta al array de archivos
                $archivos[] = $adjuntosPath;
            }
        }

        // Convertir el array de archivos a una cadena JSON
        $archivosJson = json_encode($archivos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Guardar el ticket en la base de datos, incluyendo el campo 'tipo'
        Soporte::create([
            'remitente' => $remitenteId,
            'receptor' => $request->receptor,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'adjuntos' => $archivosJson,
            'tipo' => 'enviado',
            'fecha_soporte' => now(), // Agregar fecha actual
        ]);

        return redirect('/soporte')->with('success', 'Ticket enviado correctamente.');
    }
    public function recibidos()
    {
        // Obtener los tickets enviados para el usuario autenticado y los tickets en papelera
        $ticketsRecibidos = Soporte::where('receptor', auth()->id())
            ->where(function ($query) {
                $query->where('tipo', 'enviado')
                    ->orWhere(function ($query) {
                        $query->where('tipo', 'papelera')
                            ->whereJsonDoesntContain('papelera', auth()->id());
                    });
            })
            ->get();

        return view('soporte.recibidos', compact('ticketsRecibidos'));
    }

    public function enviados()
    {
        // Obtener los tickets enviados por el usuario autenticado y los tickets en papelera
        $ticketsEnviados = Soporte::where('remitente', auth()->id())
            ->where(function ($query) {
                $query->where('tipo', 'enviado')
                    ->orWhere(function ($query) {
                        $query->where('tipo', 'papelera')
                            ->whereJsonDoesntContain('papelera', auth()->id());
                    });
            })
            ->get();

        return view('soporte.enviados', compact('ticketsEnviados'));
    }

    public function lecturaTicket($id, Request $request)
    {
        $ticket = Soporte::find($id);
        $origen = $request->input('origen', '');

        // Verificar si se está enviando a la papelera
        if ($request->has('enviar_papelera')) {
            // Obtener el array actual y agregar el ID del usuario autenticado
            $papelera = json_decode($ticket->papelera, true) ?: [];
            $papelera[] = $request->user()->id;

            // Eliminar duplicados (si los hay)
            $papelera = array_unique($papelera);

            // Actualizar el campo 'papelera' con la lista actualizada
            $ticket->update(['papelera' => json_encode($papelera), 'tipo' => 'papelera']);

            // Redirigir a la vista de la papelera
            return redirect('/soporte')->with('success', 'Ticket enviado a la papelera correctamente.');
        }

        return view('soporte.lectura-ticket', compact('ticket', 'origen'));
    }

    public function papelera()
    {
        // Obtener los tickets en la papelera enviados por el usuario autenticado
        $ticketsPapelera = Soporte::where('tipo', 'papelera')
            ->whereJsonContains('papelera', auth()->id())
            ->get();

        return view('soporte.papelera', compact('ticketsPapelera'));
    }

    public function enviarAPapelera(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $usuarioId = Auth::id();

        // Obtener los IDs de los tickets a enviar a la papelera
        $idsSeleccionados = $request->input('ids', []);

        // Lógica para enviar los tickets a la papelera
        foreach ($idsSeleccionados as $id) {
            $ticket = Soporte::find($id);

            // Obtener el array actual y agregar el ID del usuario autenticado
            $papelera = json_decode($ticket->papelera, true) ?: [];
            $papelera[] = $usuarioId;

            // Eliminar duplicados (si los hay)
            $papelera = array_unique($papelera);

            // Actualizar el campo 'papelera' con la lista actualizada
            $ticket->update(['tipo' => 'papelera', 'papelera' => json_encode($papelera)]);
        }

        // Mensaje de éxito para mostrar en la interfaz de usuario
        $successMessage = 'Tickets masivos enviados a la papelera correctamente.';

        // Redirigir a la vista de la papelera con un mensaje de éxito
        return response()->json(['success' => true, 'message' => $successMessage]);
    }
    public function recuperarDePapelera(Request $request)
    {
        // Obtener los IDs de los tickets a recuperar de la papelera
        $idsSeleccionados = $request->input('ids', []);
    
        // Lógica para recuperar los tickets de la papelera
        foreach ($idsSeleccionados as $id) {
            $ticket = Soporte::find($id);
    
            // Obtener el array actual y quitar el ID del usuario autenticado
            $papelera = json_decode($ticket->papelera, true) ?: [];
            $papelera = array_diff($papelera, [auth()->id()]);
    
            // Actualizar el campo 'papelera' solo si hay elementos en el array
            $ticket->update(['tipo' => 'enviado', 'papelera' => $papelera ? json_encode($papelera) : null]);
        }
    
        return response()->json(['success' => true, 'message' => 'Tickets recuperados de la papelera correctamente.']);
    }
    
}
