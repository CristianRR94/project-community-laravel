<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//modelo participante para crear array - más fácil de trastear que json
class Participante extends Model
{
    use HasFactory;

    protected $connection = "mysql2";

    protected $fillable = [
        "participante"
    ];

     //establecer conexion participantes - evento n:m
     public function eventos(){
        return $this->belongsToMany(Evento::class, "participante");
    }
}
