<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Http\Controllers\Controller;
use App\Models\Participante;
use App\Models\Usuario;

class EventoControlador extends Controller
{
    //Crear evento (correcto------------------------------------------------------------------------------------------------)
    //cambiar asistencia por (capacidad de modificacion por parte de todos los asistenetes [Encontrar mejor nombre])
    public function CrearEvento(Request $request){
        $evento = Evento::create([
            "nombre" => $request -> nombre,
            "tipo" => $request -> tipo,
            "asistencia" => $request -> asistencia,
            "fecha" => $request -> fecha,
            //"participantes" => json_encode($request -> participantes),
            "elementos" => json_encode($request -> elementos),
        ]);
        //añadir directamente al creador como participante
        $token = $request->bearerToken();
        $usuario = Usuario::where("apiToken", hash("sha256", $token))->first();
        if($usuario){
            $participante = Participante::where("usuario_id", $usuario->id)->first();
            if($participante){
                $evento->participantes()->attach($participante);
                return response()->json([
                    "status"=>200,
                    "mensaje"=>"participante agregado con exito"
                ],200);
            }
        }
    }

    //Ver eventos
    public function verEvento(Request $requets){
        $evento=Evento::all();
        if ($evento -> count() > 0){
            return response()->json([
                "status" => 200,
                "mensaje" => $evento
             ], 200);
        }
        else {
            return response()->json([
                "status" => 404,
                "mensaje" => "Sin informacion"
             ], 200);
        }
    }

    //Modificar eventos
    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            "nombre" => "required|string",
            "tipo" => "required|string",
            "asistencia" => "required|boolean",
            "fecha" => "required|date",
            //"participantes" => "required|array",
            "elementos" => "required|array",
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            $evento = Evento::find($id);

            if($evento){
                $evento -> update([
                    "nombre" => $request -> nombre,
                    "tipo" => $request -> tipo,
                    "asistencia" => $request -> asistencia,
                    "fecha" => $request -> fecha,
                    //"participantes" => json_encode($request -> participantes),
                    "elementos" => json_encode($request -> elementos),
                ]);

                return response() -> json([
                    "status" => 200,
                    "mensaje" => "Evento modificado correctamente"
                ], 200);
            }
            else{
                return response() -> json([
                    "status" => 404,
                    "mensaje" => "Evento no encontrado"
                ], 404);
            }
        }
    }

    //Eliminar (añadir a través de botón)
    public function eliminar($id){
        $evento = Evento::find($id);

        if($evento){
            $evento -> delete();
            return response()->json([
                "mensaje" => "Evento eliminado correctamente"
            ], 200);

        }
        else{
            return response() -> json([
                "status" => 404,
                "mensaje" => "Evento no encontrado"
            ], 404);
        }
    }

    //Ver evento (singular)
    public function leer($id){
        $evento = Evento::find($id);
        if($evento){
            return response()->json([
                "status" => 200,
                "evento" => $evento
            ], 200);
        }
        else{
            return response() -> json([
                "status" => 404,
                "mensaje" => "Evento no encontrado"
            ], 404);
        }
    }

    //añadir participantes 2 (obtener id no comprobado hasta vista)(comprado funcionamiento)------------------------------------------------------------------------
    public function añadirParticipante(Request $request, $id_evento){
        $evento = Evento::find($id_evento);
        $nombreParticipante = $request -> input("nombreParticipante");
        $participante = Participante::where("participante", $nombreParticipante)->first();
        if ($participante){
            if (!$evento->participantes->contains($participante->id)){
                $evento->participantes()->attach($participante);
                return response()->json([
                    "status"=> 200,
                    "mensaje"=>"participante agregado con éxito"
                ]);
            }
            else {
                return response()->json([
                    "status"=> 500,
                    "mensaje"=>"participante ya introducido"
                ]);
            }
        }
        else{
            return response()->json([

                "status"=> 404,
                "mensaje"=>"nombre no encontrado"
            ]);
        }
    }

    //ver participantes del evento

    public function verParticipantes($id_evento){ //quizas haya que añadir Request (no comprobado)
        $evento = Evento::find($id_evento);
        if ($evento){
            $participantes = $evento->participantes;
            return response()->json([
                "status"=> 200,
                "participantes"=>$participantes
            ]);
        }
        else{
            return response()->json([
                "status"=> 404,
                "mensaje"=>"Evento no encontrado"
            ]);
        }
    }
}
