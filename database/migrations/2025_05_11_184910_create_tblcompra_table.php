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
        Schema::create('tblcompra', function (Blueprint $table) {
            $table->id('compra_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('colocacion_id');
            $table->integer('unidades')->default(0);
            $table->timestamps();

            $table->foreign('cliente_id')->references('cliente_id')->on('tblcliente')->onDelete('cascade');
            $table->foreign('articulo_id')->references('articulo_id')->on('tblarticulo')->onDelete('cascade');
            $table->foreign('colocacion_id')->references('colocacion_id')->on('tblcolocacion')->onDelete('cascade');

            $table->unique(['cliente_id', 'articulo_id', 'colocacion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcompra');
    }
};
