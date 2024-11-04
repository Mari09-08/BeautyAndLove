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
        Schema::create('profesionales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1', 25);
            $table->string('nombre2', 25)->nullable();
            $table->string('apellido1', 25);
            $table->string('apellido2', 25)->nullable();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Relación con users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesionales');
    }
};
