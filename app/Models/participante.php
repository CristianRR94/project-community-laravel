<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//modelo participante para crear array - más fácil de trastear que json
class Participante extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $fillable = [
        "participante",
        "usuario_id"
    ];

     //establecer conexion participantes - evento n:m
    public function eventos(){
        return $this->belongsToMany(Evento::class, "evento_participante");
    }
    //conectar participante con el usuario
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
}
