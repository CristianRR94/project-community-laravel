<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use app\Models\evento;

class EventoControlador extends Controller
{
    //Crear evento
    public function evento(Request $request){
        $evento = Evento::create([
            "nombre" => $request -> nombre,
            "tipo" => $request -> tipo,
            "asistencia" => $request -> asistencia,
            "fecha" => $request -> fecha,
            "personas" => json_encode($request -> personas),
            "elementos" => json_encode($request -> elementos),
        ]);

        if($evento){
            return response() -> json([
                "status" => 200,
                "mensaje" => "Evento creado correctamente"
            ], 200);
        }
        else{
            return response() -> json([
                "status" => 500,
                "mensaje" => "Ha habido un error"
            ], 500);
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
            "personas" => "required|array",
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
                    "personas" => json_encode($request -> personas),
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
        $usuario = Evento::find($id);
        if($usuario){
            return response()->json([
                "status" => 200,
                "usuario" => $evento
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
