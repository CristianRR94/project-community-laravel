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
  "personas",
  "elementos",

    ];
}
