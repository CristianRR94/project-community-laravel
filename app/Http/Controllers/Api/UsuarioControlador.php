<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsuarioControlador extends Controller
{
    // LIST
    public function usuarios(Request $request){
        $usuarios=Usuario::all();
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
            "name" => "required|string|max:20",
            "email" => "required|email",
            "password" => "required|string"
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            $usuario = Usuario::create([
                "name" => $request -> name,
                "email" => $request -> email,
                "password" => Hash::make($request -> password)
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
            "name" => "required|string|max:20",
            "email" => "required|email",
            "password" => "required|string"
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
                    "name" => $request -> name,
                    "email" => $request -> email,
                    "password" => Hash::make($request -> password)
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


    //LOGIN
    public function autenticar(Request $request): JsonResponse{
         $credentials = $request -> validate ([
            "name" => ["required"],
            "password" => ["required"]
        ]);
        $usuario = Usuario::where('name', $credentials['name'])->first();
        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {

            $token = Str::random(60);
            $usuario->forceFill([
                "apiToken" => hash("sha256", $token),
            ])->save();

            return response()->json(["token" => $token]);
        }
        else{
            return response()-> json([
                "status" => 401,
                "mensaje" => "Usuario erróneo"
            ], 401);
        }
    }


    //LOGOUT
    public function logout(Request $request){
        Auth::logout();

        $request -> session() -> invalidate();
        $request -> session() -> regenerateToken();

        return redirect(route(`localhost://4200`));
    }
    }


