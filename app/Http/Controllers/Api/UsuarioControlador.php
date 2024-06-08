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
use Illuminate\Support\Facades\DB;
use App\Models\Participante;

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

    //CREATE (correcto)--------------------------------------------------------------------------------------------------------------------------------------------
    public function crearUsuario(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:20",
            "email" => "required|email",
            "password" => "required|string|min:6"
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            if (Usuario::where("name", $request->name)->exists()){
                return response()->json([
                    "status" => 409,
                    "mensaje"=> "Nombre ya en uso"
                ], 409);
            }
            else if (Usuario::where("email", $request->email)->exists()){
                return response()->json([
                    "status" => 500,
                    "mensaje"=> "Email ya en uso"
                ], 500);
            }
            else{
                $usuario=null;
                $participante=null;
                DB::transaction(function () use ($request, &$usuario, &$participante){ //uso de & para pasar variables por referencia (modifica el valor)
                    //si algo no funciona no se crea nada
                    $usuario = Usuario::create([
                        "name" => $request -> name,
                        "email" => $request -> email,
                        "password" => Hash::make($request -> password)
                    ]);
                    //añadir usuario a participantes
                    $participante = Participante::create([
                        "usuario_id"=>$usuario->id,
                        "participante"=>$usuario->name
                        //"evento_id"=> null
                    ]);
                });
                if(!$usuario){
                    return response() -> json([
                        "status" => 500,
                        "mensaje" => "Error al crear usuario"
                    ], 500);
                }
                else if (!$participante){
                    return response() -> json([
                        "status" => 500,
                        "mensaje" => "Error al crear participante"
                    ], 500);
                }
                else{
                    return response() -> json([
                        "status" => 200,
                        "mensaje" => "Usuario y participante creados correctamente"
                    ], 200);
                }
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
            "password" => "required|string|min:6"
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

    //funcion a la que llamar para hacer update
    protected function cambiarUsuario($usuario, $request){
        $usuario -> update([
            "name" => $request -> name,
            "email" => $request -> email,
            "password" => Hash::make($request -> password)
        ]);
    }

    //UPDATE desde la propia sesion(correcto)--------------------------------------------------------------------------------------------------------------------
    public function actualizar(Request $request){
        $token = $request->bearerToken();
        $comporbarUsuario = Usuario::where("apiToken", hash("sha256", $token))->first();
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:20",
            "email" => "required|email",
            "password" => "required|string|min:6"
        ]);
        if ($validator-> fails()){
            return response()->json([
                "status" => 422,
                "errores" => $validator -> messages()
            ],422);
        }
        else {
            if($comporbarUsuario){
                $token = $request->bearerToken();
                $usuario = Usuario::where("apiToken", hash("sha256", $token))->first();
                $participante = Participante::where("usuario_id", $usuario->id)->first();
                $usuarioActual = Usuario::where("name", $request->name)->first();
                $emailActual = Usuario::where("email", $request->email)->first();
                //nombre o mail en uso
                if($usuario->where("name", $request->name)->exists() || $usuario->where("email", $request->email)->exists()){
                    if($usuarioActual && $usuarioActual->id != $usuario->id){
                        return response()->json([
                            "status"=> 409,
                            "mensaje"=> "Nombre de usuario ya en uso"
                        ], 409);
                    }
                    else if ($emailActual && $emailActual->id != $usuario->id){
                        return response()->json([
                            "status"=> 409,
                            "mensaje"=> "Email ya en uso"
                        ], 409);
                    }
                    //mismo nombre o email que tenía el usuario
                    else{
                        $this->cambiarUsuario($usuario, $request);
                        $participante->update([
                            "participante"=>$usuario->name
                        ]);
                        return response() -> json([
                            "status" => 200,
                            "mensaje" => "Usuario editado correctamente"
                        ], 200);
                    }
                }
                else if($usuario){
                    $this->cambiarUsuario($usuario, $request);
                    $participante->update([
                        "participante"=>$usuario->name
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
            else{
                return response()->json([
                    "status"=>401,
                    "mensaje"=>"Usuario no autenticado"
                ], 401);
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

    //DELETE desde la propia sesion (correcto) ---------------------------------------------------------------------------------------------------------------------
    public function eliminarUsuario(Request $request){
        $token = $request->bearerToken();
        $usuario = Usuario::where("apiToken", hash("sha256", $token))->first();

        if($usuario){
            $id = $usuario->id;
            $participante = Participante::where("usuario_id", $id)->first();
            if($participante){
                $participante -> delete();
            }
            else {
                return response()->json([
                    "status" => 500,
                    "mensaje" => "Ha habido un error"
                ]);
            }
                $usuario -> delete();
                //$request -> session() -> invalidate();

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

    //LOGIN --------------------------------------------------------------------------------------------------------------------------------------------------------
    public function autenticar(Request $request): JsonResponse{
         $credentials = $request -> validate ([
            "name" => ["required"],
            "password" => ["required"]
        ]);
        $usuario = Usuario::where('name', $credentials['name'])->first();
        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {

            //crear token (nueva columna)

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


    //LOGOUT (pendiente de comprobación)
    public function logout(Request $request){
      $token = $request->bearerToken();
      $usuario = Usuario::where("apiToken", hash("sha256", $token))->first();
      if($usuario){
        $usuario->forceFill([
            "apiToken" => null
        ])->save();

        return response()-> json([
            "status" => 200,
            "mensaje" => "Sesión cerrada"
        ], 200);
      }
      else {
        return response()-> json([
            "status" => 500,
            "mensaje" => "Error en el cierre de sesión"
        ], 500);
      }
    }
}


