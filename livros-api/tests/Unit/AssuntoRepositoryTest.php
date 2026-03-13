<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Models\Assunto;
use App\Http\Repositories\AssuntoRepository;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class AssuntoRepositoryTest extends TestCase
{
    protected AssuntoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AssuntoRepository();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_all_retorna_lista_de_assuntos()
    {
        $assuntosMock = new Collection([
            ['descricao' => 'Literatura Brasileira'],
            ['descricao' => 'Ficção Científica']
        ]);

        $assuntoModel = Mockery::mock('alias:' . \App\Models\Assunto::class);
        $assuntoModel->shouldReceive('all')
            ->once()
            ->andReturn($assuntosMock);

        $result = $this->repository->all();
        $this->assertCount(2, $result);
    }

    public function test_paginate_assuntos()
    {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('get')->with('descricao', null)->andReturn(null);

        $this->repository = Mockery::mock(AssuntoRepository::class)->makePartial();
        $this->repository->shouldAllowMockingProtectedMethods();
        $this->repository->shouldReceive('getPaginateParams')->andReturn([
            'order_by' => 'descricao',
            'order' => 'asc',
            'limit' => 10,
            'page' => 1,
            'descricao' => null,
        ]);

        $assuntoModel = Mockery::mock('alias:' . \App\Models\Assunto::class);
        $assuntoModel->shouldReceive('getDefaultOrderBy')->andReturn('cod_assunto');
        $assuntoModel->shouldReceive('orderBy')->with(Mockery::any(), Mockery::any())->andReturnSelf();
        $assuntoModel->shouldReceive('where')->andReturnSelf();
        $paginatorMock = Mockery::mock();
        $paginatorMock->shouldReceive('appends')->with(Mockery::any())->andReturn('paginated-result');
        $assuntoModel->shouldReceive('paginate')->andReturn($paginatorMock);

        $result = $this->repository->paginate($requestMock);
        $this->assertEquals('paginated-result', $result);
    }
}
