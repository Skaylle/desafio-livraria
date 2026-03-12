<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW vw_relatorio_livros AS
             SELECT 
                A.COD_AUTOR,
                A.NOME AS AUTOR,
                L.COD_LIVRO,
                L.TITULO,
                L.EDITORA,
                L.ANO_PUBLICACAO,
                L.VALOR,
                STRING_AGG(S.DESCRICAO, ', ') AS ASSUNTOS
            FROM LIVROS L
            JOIN LIVRO_AUTOR LA ON L.COD_LIVRO = LA.COD_LIVRO
            JOIN AUTORS A ON LA.COD_AUTOR = A.COD_AUTOR
            LEFT JOIN LIVRO_ASSUNTO LS ON L.COD_LIVRO = LS.COD_LIVRO
            LEFT JOIN ASSUNTOS S ON LS.COD_ASSUNTO = S.COD_ASSUNTO
            GROUP BY 
                A.COD_AUTOR,
                A.NOME,
                L.COD_LIVRO,
                L.TITULO,
                L.EDITORA,
                L.ANO_PUBLICACAO,
                L.VALOR
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS vw_relatorio_livros");
    }
};