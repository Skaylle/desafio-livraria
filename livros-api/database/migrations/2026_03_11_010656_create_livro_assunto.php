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
            $table->unsignedBigInteger('cod_livro')->index();
            $table->unsignedBigInteger('cod_assunto')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['cod_livro', 'cod_assunto']);

            $table->foreign('cod_livro')->references('cod_livro')->on('livros')->onDelete('cascade');
            $table->foreign('cod_assunto')->references('cod_assunto')->on('assuntos')->onDelete('cascade');
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
