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
        Schema::table('usuarios', function (Blueprint $table) {
            //
            $table->renameColumn('nombre', 'name');
            $table->renameColumn('contrasena', 'password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            //
            $table->renameColumn('name', 'nombre');
            $table->renameColumn('password', 'contrasena');
        });
    }
};
