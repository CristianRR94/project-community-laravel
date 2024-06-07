<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Participante;
use App\Models\Evento;

class ParticipanteControlador extends Controller
{
    // Añadir participante automático

    //LIST
    public function verParticipantes(Request $request){
        $participantes=Participante::all();
        if ($participantes -> count() > 0){
            return response()->json([
                "status" => 200,
                "mensaje" => $participantes
             ], 200);
        }
        else {
            return response()->json([
                "status" => 404,
                "mensaje" => "Sin informacion"
             ], 200);
        }
    }

}
