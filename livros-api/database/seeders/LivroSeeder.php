<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivroSeeder extends Seeder
{
    public function run()
    {
        // --- 1) Autores ---
        $autores = [
            'Machado de Assis',
            'Clarice Lispector',
            'Jorge Amado',
            'Paulo Coelho',
            'Graciliano Ramos',
            'José Saramago',
            'Carlos Drummond de Andrade',
            'Érico Veríssimo',
            'Lygia Fagundes Telles',
            'Manuel Bandeira'
        ];

        $autoresInsert = [];
        foreach ($autores as $index => $nome) {
            $autoresInsert[] = [
                'cod_autor' => $index + 1,
                'nome' => $nome,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('autors')->insert($autoresInsert);
        DB::statement("SELECT setval('autors_cod_autor_seq', (SELECT MAX(cod_autor) FROM autors))");

        // --- 2) Assuntos ---
        $assuntos = [
            'Romance', 'Ficção', 'Poesia', 'Drama', 'Conto', 'Biografia',
            'História', 'Infantil', 'Aventura', 'Mistério', 'Fantasia',
            'Autoajuda', 'Ciência', 'Filosofia', 'Religião', 'Psicologia',
            'Educação', 'Economia', 'Política', 'Sociologia', 'Tecnologia',
            'Arte', 'Cinema', 'Teatro', 'Fotografia', 'Crítica', 'Ensaios',
            'Jornalismo', 'Viagem', 'Gastronomia', 'Esportes', 'Música',
            'Ciência Política', 'Medicina', 'Direito', 'Psicanálise',
            'Romance Histórico', 'Ficção Científica', 'Quadrinhos', 'Literatura Infantil'
        ];

        $assuntosInsert = [];
        foreach ($assuntos as $index => $descricao) {
            $assuntosInsert[] = [
                'cod_assunto' => $index + 1,
                'descricao' => $descricao,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('assuntos')->insert($assuntosInsert);
        DB::statement("SELECT setval('assuntos_cod_assunto_seq', (SELECT MAX(cod_assunto) FROM assuntos))");

        // --- 3) Livros ---
        $editoras = ['Companhia das Letras', 'Record', 'Saraiva', 'Globo', 'Rocco'];
        $livros = [];
        for ($i = 1; $i <= 100; $i++) {
            $livros[] = [
                'cod_livro' => $i,
                'titulo' => "Livro Exemplo $i",
                'editora' => $editoras[array_rand($editoras)],
                'edicao' => rand(1,10),
                'ano_publicacao' => strval(rand(1980,2024)),
                'valor' => rand(1000,10000)/100,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('livros')->insert($livros);
        DB::statement("SELECT setval('livros_cod_livro_seq', (SELECT MAX(cod_livro) FROM livros))");

        // --- 4) Relacionamento Livro_Autor ---
        $livroAutor = [];
        foreach ($livros as $livro) {
            $qtdAutores = rand(1,3); // cada livro 1 a 3 autores
            $autoresAleatorios = array_rand(array_flip(range(1,10)), $qtdAutores);
            foreach ((array)$autoresAleatorios as $autorId) {
                $livroAutor[] = [
                    'cod_livro' => $livro['cod_livro'],
                    'cod_autor' => $autorId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('livro_autor')->insert($livroAutor);

        // --- 5) Relacionamento Livro_Assunto ---
        $livroAssunto = [];
        foreach ($livros as $livro) {
            $qtdAssuntos = rand(1,4); // cada livro 1 a 4 assuntos
            $assuntosAleatorios = array_rand(array_flip(range(1,40)), $qtdAssuntos);
            foreach ((array)$assuntosAleatorios as $assuntoId) {
                $livroAssunto[] = [
                    'cod_livro' => $livro['cod_livro'],
                    'cod_assunto' => $assuntoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('livro_assunto')->insert($livroAssunto);

        $this->command->info('Seed de livros, autores e assuntos inserido com sucesso!');
    }
}