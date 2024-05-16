<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ParticipanteControlador extends Controller
{
    // Añadir participante
   /*  public function addParticipante(Request $request){
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
    } */

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
