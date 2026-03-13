<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Repositories\AssuntoRepository;
use App\Models\Assunto;
use App\Models\Livro;

class AssuntoRepositoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected AssuntoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AssuntoRepository();
    }

    public function testCreate()
    {
        $livro = Livro::factory()->create();

        $request = new Request([
            'descricao' => 'Literatura',
            'selectedLivros' => [$livro->cod_livro]
        ]);

        $assunto = $this->repository->create($request);

        $this->assertDatabaseHas('assuntos', [
            'descricao' => 'Literatura'
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'cod_livro' => $livro->cod_livro,
            'cod_assunto' => $assunto->cod_assunto
        ]);
    }

    public function testUpdate()
    {
        $livro = Livro::factory()->create();
        $assunto = Assunto::factory()->create([
            'descricao' => 'Assunto Antigo'
        ]);

        $request = new Request([
            'descricao' => 'Assunto Atualizado',
            'selectedLivros' => [$livro->cod_livro]
        ]);

        $assunto = $this->repository->update($request, $assunto->cod_assunto);

        $this->assertDatabaseHas('assuntos', [
            'descricao' => 'Assunto Atualizado'
        ]);

        $this->assertDatabaseHas('livro_assunto', [
            'cod_livro' => $livro->cod_livro,
            'cod_assunto' => $assunto->cod_assunto
        ]);
    }
}