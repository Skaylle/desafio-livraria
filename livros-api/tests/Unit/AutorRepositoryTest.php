<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Models\Autor;
use App\Http\Repositories\AutorRepository;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class AutorRepositoryTest extends TestCase
{
    protected AutorRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AutorRepository();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_all_retorna_lista_de_autores()
    {
        $autoresMock = new Collection([
            ['nome' => 'Machado de Assis'],
            ['nome' => 'Clarice Lispector']
        ]);

        $autorModel = Mockery::mock('alias:' . \App\Models\Autor::class);
        $autorModel->shouldReceive('all')
            ->once()
            ->andReturn($autoresMock);

        $result = $this->repository->all();
        $this->assertCount(2, $result);
    }

    public function test_paginate_autores()
    {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('get')->with('nome', null)->andReturn(null);

        $this->repository = Mockery::mock(AutorRepository::class)->makePartial();
        $this->repository->shouldAllowMockingProtectedMethods();
        $this->repository->shouldReceive('getPaginateParams')->andReturn([
            'order_by' => 'nome',
            'order' => 'asc',
            'limit' => 10,
            'page' => 1,
            'nome' => null,
        ]);

        $autorModel = Mockery::mock('alias:' . \App\Models\Autor::class);
        $autorModel->shouldReceive('getDefaultOrderBy')->andReturn('cod_autor');
        $autorModel->shouldReceive('orderBy')->with(Mockery::any(), Mockery::any())->andReturnSelf();
        $autorModel->shouldReceive('where')->andReturnSelf();
        $paginatorMock = Mockery::mock();
        $paginatorMock->shouldReceive('appends')->with(Mockery::any())->andReturn('paginated-result');
        $autorModel->shouldReceive('paginate')->andReturn($paginatorMock);

        $result = $this->repository->paginate($requestMock);
        $this->assertEquals('paginated-result', $result);
    }
}
