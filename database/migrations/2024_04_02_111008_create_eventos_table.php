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
        Schema::connection(`mysql2`)->create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("tipo");
            $table->boolean("asistencia");
            $table->date("fecha");
            $table->array("participantes");
            $table->array("elementos");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};