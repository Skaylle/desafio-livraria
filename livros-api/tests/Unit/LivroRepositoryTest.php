<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Livro;
use App\Http\Repositories\LivroRepository;
use Illuminate\Support\Collection;

class LivroRepositoryTest extends TestCase
{
    protected LivroRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new LivroRepository();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testAll()
    {
        $livrosMock = new Collection([
            ['titulo' => 'Dom Casmurro'],
            ['titulo' => 'Memórias Póstumas']
        ]);

        $livroModel = Mockery::mock('alias:' . Livro::class);
        $livroModel->shouldReceive('all')
            ->once()
            ->andReturn($livrosMock);

        $result = $this->repository->all();

        $this->assertCount(2, $result);
    }

    public function testDelete()
    {
        $livroModel = Mockery::mock('alias:' . Livro::class);

        $livroModel->shouldReceive('destroy')
            ->once()
            ->with(1)
            ->andReturn(1);

        $result = $this->repository->delete(1);

        $this->assertEquals(1, $result);
    }

    public function testFind()
    {
        $livroFake = new \App\Models\Livro();
        $livroFake->titulo = "Dom Casmurro";

        $livroModel = Mockery::mock('alias:' . Livro::class);

        $livroModel->shouldReceive('with')
            ->once()
            ->with(['autores', 'assuntos'])
            ->andReturnSelf();

        $livroModel->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($livroFake);

        $result = $this->repository->find(1);

        $this->assertEquals("Dom Casmurro", $result->titulo);
    }

    public function testPaginateLivros()
    {
        $requestMock = Mockery::mock('Illuminate\\Http\\Request');
        $requestMock->shouldReceive('get')->with('titulo', null)->andReturn(null);
        $requestMock->shouldReceive('get')->with('editora', null)->andReturn(null);
        $requestMock->shouldReceive('get')->with('edicao', null)->andReturn(null);
        $requestMock->shouldReceive('get')->with('ano_publicacao', null)->andReturn(null);

        // Simula parâmetros de paginação
        $this->repository = Mockery::mock(LivroRepository::class)->makePartial();
        $this->repository->shouldAllowMockingProtectedMethods();
        $this->repository->shouldReceive('getPaginateParams')->andReturn([
            'order_by' => 'titulo',
            'order' => 'asc',
            'limit' => 10,
            'page' => 1,
            'titulo' => null,
            'editora' => null,
            'edicao' => null,
            'ano_publicacao' => null,
        ]);

        $livroModel = Mockery::mock('alias:' . Livro::class);
        $livroModel->shouldReceive('getDefaultOrderBy')->andReturn('cod_livro');
        $livroModel->shouldReceive('orderBy')->with('titulo', 'asc')->andReturnSelf();
        $livroModel->shouldReceive('where')->andReturnSelf();
        $paginatorMock = Mockery::mock();
        $paginatorMock->shouldReceive('appends')->with(Mockery::any())->andReturn('paginated-result');
        $livroModel->shouldReceive('paginate')->with(10, ['*'], 'page', 1)->andReturn($paginatorMock);

        $result = $this->repository->paginate($requestMock);
        $this->assertEquals('paginated-result', $result);
    }
}