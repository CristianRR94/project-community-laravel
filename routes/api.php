<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioControlador;
use App\Http\Controllers\Api\EventoControlador;


//Autenticacion
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("usuarios",[UsuarioControlador::class, "usuarios"]);
Route::post("usuarios",[UsuarioControlador::class, "login"]);
Route::get("usuarios/{id}",[UsuarioControlador::class, "leer"]);
Route::get("usuarios/editar/{id}",[UsuarioControlador::class, "editar"]);
Route::put("usuarios/editar/{id}",[UsuarioControlador::class, "update"]);
Route::delete("usuarios/eliminar/{id}",[UsuarioControlador::class, "eliminar"]);
Route::post("autenticar", [UsuarioControlador::class, "autenticar"]);
Route::post("logout", [UsuarioControlador::class, "logout"]);

//Eventos
Route::post("evento",[EventoControlador::class, "evento"]);
Route::get("evento", [EventoControlador::class, "verEvento"]);
Route::put("evento/editar/{id}",[EventoControlador::class, "editar"]);
Route::delete("evento/eliminar/{id}",[EventoControlador::class, "eliminar"]);
Route::get("evento/{id}",[EventoControlador::class, "leer"]);

//participante
Route::post("participante",[ParticipanteControlador::class, "addParticipante"]);


