<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evento_participante', function (Blueprint $table) {
            $table->id();

            $table->timestamps();
        });
        Schema::table('evento_participante', function (Blueprint $table) {
            $table->foreignId("evento_id")->constrained(); //toma el id de tabla eventos
            $table->foreignId("participante_id")->constrained(); //toma el id de tabla participantes
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_participante');
    }
};
