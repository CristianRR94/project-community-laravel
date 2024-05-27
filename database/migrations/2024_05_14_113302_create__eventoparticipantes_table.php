<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
//tabla intermedia entre participantes y eventos
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_eventoparticipantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("evento_id")->nullable()->constrained(); //toma el id de tabla eventos
            $table->foreignId("participantes_id")->constrained(); //toma el id de tabla participantes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_eventoparticipantes');

    Schema::table('_eventoparticipantes', function (Blueprint $table) {
        $table->dropColumn('evento_id');
    });
}
};
