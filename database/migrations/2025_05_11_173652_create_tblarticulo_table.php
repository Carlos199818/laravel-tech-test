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
        Schema::create('tblarticulo', function (Blueprint $table) {
            $table->id('articulo_id');
            $table->string('codigo_barra')->unique();
            $table->string('descripcion');
            $table->string('fabricante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblarticulo');
    }
};
