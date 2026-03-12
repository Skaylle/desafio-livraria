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
        Schema::create('livro_assunto', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_livro');
            $table->unsignedBigInteger('cod_assunto');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cod_livro')->references('cod_livro')->on('livros');
            $table->foreign('cod_assunto')->references('cod_assunto')->on('assuntos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livro_assunto');
    }
};
