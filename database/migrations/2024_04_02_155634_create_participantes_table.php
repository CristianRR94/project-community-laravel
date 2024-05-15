<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = "mysql";
    /**
     * Run the migrations.
     */
    public function up(): void
    {   //!! - hay que terminar la migracion
        //obtener nombre de usuario de tabla usuario a través de la id
        Schema::connection("mysql")->create("participantes", function (Blueprint $table) {
            $table->id();
            $table->string("participante");
            $table->foreignId("evento_id")->constrained("eventos");
            $table->foreignId("usuario_id")->constrained("usuarios");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("participantes");
    }
};
