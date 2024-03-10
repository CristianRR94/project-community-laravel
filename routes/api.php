<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioControlador;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("usuarios",[UsuarioControlador::class, "usuarios"]);
Route::post("usuarios",[UsuarioControlador::class, "login"]);
Route::get("usuarios/{id}",[UsuarioControlador::class, "leer"]);
Route::get("usuarios/editar/{id}",[UsuarioControlador::class, "editar"]);
Route::put("usuarios/editar/{id}",[UsuarioControlador::class, "update"]);
Route::delete("usuarios/eliminar/{id}",[UsuarioControlador::class, "eliminar"]);
