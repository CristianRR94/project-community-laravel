<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ParticipanteControlador extends Controller
{
    // Añadir participante
    public function addParticipante(Request $request){
        //añadir comprobación participante - usuario



        $participante = Participante::create([
            "participante"=>$request -> participante
        ]);
        if($participante){
             return response()->json([
                "status" => 200,
                "mensaje" => "Participante añadido correctamente"
            ]);
        }
        else {
            return response()->json([
                "status" => 500,
                "mensaje" => "Ha habido un error"
            ]);
        }
    }
}
