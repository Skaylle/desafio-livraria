<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Repositories\LivroRepository;
use App\Models\Autor;
use App\Models\Assunto;
use App\Models\Livro;

class LivroRepositoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected LivroRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new LivroRepository();
    }

    public function testCreate()
    {
        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        $request = new Request([
            'titulo' => 'Dom Casmurro',
            'editora' => 'Editora A',
            'edicao' => 1,
            'ano_publicacao' => '1899',
            'valor' => 20,
            'selectedAuthors' => [$autor->cod_autor],
            'selectedAssuntos' => [$assunto->cod_assunto]
        ]);

        $livro = $this->repository->create($request);

        $this->assertDatabaseHas('livros', ['titulo' => 'Dom Casmurro']);

        $this->assertDatabaseHas('livro_autor', [
            'cod_livro' => $livro->cod_livro,
            'cod_autor' => $autor->cod_autor
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'cod_livro' => $livro->cod_livro,
            'cod_assunto' => $assunto->cod_assunto
        ]);
    }

    public function testUpdate()
    {
        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        $livro = Livro::factory()->create(['titulo' => 'Livro antigo']);

        $request = new Request([
            'titulo' => 'Livro atualizado',
            'selectedAuthors' => [$autor->cod_autor],
            'selectedAssuntos' => [$assunto->cod_assunto]
        ]);

        $livro = $this->repository->update($request, $livro->cod_livro);

        $this->assertDatabaseHas('livros', ['titulo' => 'Livro atualizado']);

        $this->assertDatabaseHas('livro_autor', [
            'cod_livro' => $livro->cod_livro,
            'cod_autor' => $autor->cod_autor
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'cod_livro' => $livro->cod_livro,
            'cod_assunto' => $assunto->cod_assunto
        ]);
    }
}