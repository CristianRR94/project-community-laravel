<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioControlador;
use App\Http\Controllers\Api\EventoControlador;


//Autenticacion
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::middleware(["api", "web"])->group(function(){});
Route::get("usuarios",[UsuarioControlador::class, "usuarios"]); //listar
Route::post("usuarios",[UsuarioControlador::class, "crearUsuario"]); //crear usuario y participante
Route::get("usuarios/{id}",[UsuarioControlador::class, "leer"]);
Route::get("usuarios/editar/{id}",[UsuarioControlador::class, "editar"]);
Route::put("usuarios/editar/{id}",[UsuarioControlador::class, "update"]);
Route::put("usuarios/editar",[UsuarioControlador::class, "actualizar"]); //cambiar usuario desde la sesion
Route::delete("usuarios/eliminar/{id}",[UsuarioControlador::class, "eliminar"]);
Route::delete("usuarios/eliminar",[UsuarioControlador::class, "eliminarUsuario"]); //eliminar usuario desde la sesion
Route::post("autenticar", [UsuarioControlador::class, "autenticar"]);
Route::post("logout", [UsuarioControlador::class, "logout"]);

//Eventos
Route::post("evento",[EventoControlador::class, "crearEvento"]);
Route::get("evento", [EventoControlador::class, "verEvento"]);
Route::put("evento/editar/{id}",[EventoControlador::class, "editar"]);
Route::delete("evento/eliminar/{id}",[EventoControlador::class, "eliminar"]);
Route::get("evento/{id}",[EventoControlador::class, "leer"]); //ver un solo evento
Route::post("evento/{id}/participantes",[EventoControlador::class, "añadirParticipante"]);
Route::get("evento/{id}/participantes",[EventoControlador::class, "verParticipantes"]);

//participante
Route::post("participante",[ParticipanteControlador::class, "addParticipante"]);
Route::get("participante",[ParticipanteControlador::class, "verParticipante"]);


