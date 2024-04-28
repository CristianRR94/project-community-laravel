<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//modelo participante para crear array - más fácil de trastear que json
class Participante extends Model
{
    use HasFactory;

    protected $fillable = [
        "participante"
    ];
}
