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
        Schema::create('pinturas', function (Blueprint $table) {
            $table->id();
            // Relación con la tabla artistas: si se borra un artista, se borran sus pinturas automáticamente
            $table->foreignId('artista_id')->constrained('artistas')->onDelete('cascade');
            $table->string('titulo');
            $table->string('tecnica');
            $table->decimal('precio', 10, 2);
            $table->string('imagen')->nullable(); // Guardará el nombre/ruta de la foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinturas');
    }
};