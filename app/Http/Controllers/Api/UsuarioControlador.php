<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioControlador extends Controller
{
    // LIST
    public function usuarios(Request $request){
        $usuarios=Usuario::all();
       /*  $data = [
            "status" => 200,
            "ususarios" => $usuarios,
        ]; */
        if ($usuarios -> count() > 0){
            return response()->json([
                "status" => 200,
                "mensaje" => $usuarios
             ], 200);
        }
        else {
            return response()->json([
                "status" => 404,
                "mensaje" => "Sin informacion"
             ], 200);
        }

    }

    //CREATE
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "nombre" => "required|string|max:20",
            "email" => "required|email",
            "contrasena" => "required|string"
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            $usuario = Usuario::create([
                "nombre" => $request -> nombre,
                "email" => $request -> email,
                "contrasena" => $request -> contrasena
            ]);

            if($usuario){
                return response() -> json([
                    "status" => 200,
                    "mensaje" => "Usuario creado correctamente"
                ], 200);
            }
            else{
                return response() -> json([
                    "status" => 500,
                    "mensaje" => "Ha habido un error"
                ], 500);
            }
        }
    }

    //READ
    public function leer($id){
        $usuario = Usuario::find($id);
        if($usuario){
            return response()->json([
                "status" => 200,
                "usuario" => $usuario
            ], 200);
        }
        else{
            return response() -> json([
                "status" => 404,
                "mensaje" => "Usuario no encontrado"
            ], 404);
        }
    }

    //UPDATE - 1
    public function editar($id){
        $usuario = Usuario::find($id);
        if($usuario){
            return response()->json([
                "status" => 200,
                "usuario" => $usuario
            ], 200);
        }
        else{
            return response() -> json([
                "status" => 404,
                "mensaje" => "Usuario no encontrado"
            ], 404);
        }
    }

    //UPDATE - 2
    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            "nombre" => "required|string|max:20",
            "email" => "required|email",
            "contrasena" => "required|string"
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            $usuario = Usuario::find($id);

            if($usuario){
                $usuario -> update([
                    "nombre" => $request -> nombre,
                    "email" => $request -> email,
                    "contrasena" => $request -> contrasena
                ]);

                return response() -> json([
                    "status" => 200,
                    "mensaje" => "Usuario editado correctamente"
                ], 200);
            }
            else{
                return response() -> json([
                    "status" => 404,
                    "mensaje" => "usuario no encontrado"
                ], 404);
            }
        }
    }

    //DELETE
    public function eliminar($id){
        $usuario = Usuario::find($id);

        if($usuario){
            $usuario -> delete();
            return response()->json([
                "mensaje" => "Usuario eliminado correctamente"
            ], 200);

        }
        else{
            return response() -> json([
                "status" => 404,
                "mensaje" => "usuario no encontrado"
            ], 404);
        }
    }
}

