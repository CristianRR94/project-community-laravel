<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;


    protected $fillable = [
        /*  id: number,
  nombre: string,
  tipo: string,
  imagen: string,
  asistencia: boolean,
  fecha: Date,
  personas: string[],
  elementos: string[], */

  "nombre",
  "tipo",
  "imagen",
  "asistencia",
  "fecha",
  "participantes",
  "elementos",

    ];
    //establecer conexion evento - participantes
    // participante como los usuarios registrados entre las bases de datos
    public function usuarios(){
        return $this -> belongsToMany(Participante::class, "participante");
    }
}
