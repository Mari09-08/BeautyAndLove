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
        Schema::create('profesional_profesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_profesional')->constrained('profesionales')->onDelete('cascade'); // Relación con profesionales
            $table->foreignId('id_profesion')->constrained('profesiones')->onDelete('cascade'); // Relación con profesiones
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesional_profesiones');
    }
};
