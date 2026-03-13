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
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_livro')->index();
            $table->unsignedBigInteger('cod_autor')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['cod_livro', 'cod_autor']);

            $table->foreign('cod_livro')->references('cod_livro')->on('livros')->onDelete('cascade');
            $table->foreign('cod_autor')->references('cod_autor')->on('autors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }
};
