<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Repositories\AutorRepository;
use App\Models\Autor;
use App\Models\Livro;

class AutorRepositoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected AutorRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AutorRepository();
    }

    public function testCreate()
    {
        $livro = Livro::factory()->create();

        $request = new Request([
            'nome' => 'Machado de Assis',
            'selectedLivros' => [$livro->cod_livro]
        ]);

        $autor = $this->repository->create($request);

        $this->assertDatabaseHas('autors', [
            'nome' => 'Machado de Assis'
        ]);

        $this->assertDatabaseHas('livro_autor', [
            'cod_livro' => $livro->cod_livro,
            'cod_autor' => $autor->cod_autor
        ]);
    }

    public function testUpdate()
    {
        $livro = Livro::factory()->create();
        $autor = Autor::factory()->create([
            'nome' => 'Autor Antigo'
        ]);

        $request = new Request([
            'nome' => 'Autor Atualizado',
            'selectedLivros' => [$livro->cod_livro]
        ]);

        $autor = $this->repository->update($request, $autor->cod_autor);

        $this->assertDatabaseHas('autors', [
            'nome' => 'Autor Atualizado'
        ]);

        $this->assertDatabaseHas('livro_autor', [
            'cod_livro' => $livro->cod_livro,
            'cod_autor' => $autor->cod_autor
        ]);
    }
}