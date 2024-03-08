<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
class UsuarioControlador extends Controller
{
    //
    public function usuarios(Rquest $request){
        $usuarios=Usuario::all();

         return response()->json($data, 200, $headers);
    }

}
