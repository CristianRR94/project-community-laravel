<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Http\Controllers\Controller;
use App\Models\Participante;

class EventoControlador extends Controller
{
    //Crear evento    la api furrula, ahora solo queda conectar todo

    public function evento(Request $request){
        $evento = Evento::create([
            "nombre" => $request -> nombre,
            "tipo" => $request -> tipo,
            "asistencia" => $request -> asistencia,
            "fecha" => $request -> fecha,
            //"participantes" => json_encode($request -> participantes),
            "elementos" => json_encode($request -> elementos),
        ]);
        //!! ver - analizar implicaciones en introduccion de participantes
       /* if($evento){

           // foreach($request->participantes as $nombreUsuario){
                //creador del evento metido directamente
           // $usuario = Usuario::where("apiToken", $request->bearerToken()->first());

                if($usuario){
                    $participante = new Participante;
                    $participante-> usuario_id = $usuario->id;
                    $participante-> evento_id = $evento->id;
                    $participante->save();
                }
            }
            return response() -> json([
                "status" => 200,
                "mensaje" => "Evento creado correctamente"
            ], 200);
        }
       // else{
       //    return response() -> json([
       //    "status" => 500,
       //         "mensaje" => "Ha habido un error"
       //     ], 500);
       // }
    //}*/
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

    //Eliminar
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

    //añadir participantes (no comprobado)
    public function addParticipante(Request $request, Evento $evento) {
        if (is_array($request->participantes)) {
            foreach ($request->participantes as $participante_nombre){
                $participante = Participante::where("participante", $participante_nombre)->first();
                if ($participante){
                    $evento->participantes()->attach($participante);
                }
                else {
                    return response() -> json([
                        "status" => 404,
                        "mensaje" => "Participante no encontrado"
                    ], 404);
                }
            }
        }
        else {
            return response() -> json([
                "status" => 500,
                "mensaje" => "Ha habido un error"
            ], 500);
        }
        return redirect()->route("evento.show", $evento);
    }
    //añadir participantes 2 (a través de boton)
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
}
