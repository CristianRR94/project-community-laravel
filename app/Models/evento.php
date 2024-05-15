<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $fillable = [

  "nombre",
  "tipo",
  "imagen",
  "asistencia",
  "fecha",
  //"participantes",
  "elementos",

    ];
    //establecer conexion evento - participantes
    // participante como los usuarios registrados entre las bases de datos
    public function usuarios(){
        return $this -> belongsToMany(Participante::class, "participante");
    }
}
