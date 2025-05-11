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
        Schema::create('tblcolocacion', function (Blueprint $table) {
            $table->id('colocacion_id');
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->unsignedBigInteger('articulo_id');
            $table->timestamps();

            $table->foreign('articulo_id')->references('articulo_id')->on('tblarticulo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcolocacion');
    }
};
