<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AssuntoRepository;
use App\Http\Requests\AssuntoRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\DefaultResource;
use App\Models\Assunto;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    /**
     * @var AssuntoRepository
     */
    protected AssuntoRepository $repository;

    public function __construct()
    {
        $this->repository = new AssuntoRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DefaultCollection
    {
        return new DefaultCollection($this->repository->paginate($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssuntoRequest $request)
    {
        $assunto = $this->repository->create($request);
        // Garante que livros_ids é retornado
        $assunto->livros_ids = $assunto->livros->pluck('cod_livro');
        return new DefaultResource($assunto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssuntoRequest $request, Assunto $Assunto)
    {
        $assunto = $this->repository->update($request, $Assunto->cod_assunto);
        $assunto->livros_ids = $assunto->livros->pluck('cod_livro');
        return new DefaultResource($assunto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assunto $Assunto)
    {
        $assunto = $this->repository->find($Assunto->cod_assunto);
        $assunto->load('livros');
        $assunto->livros_ids = $assunto->livros->pluck('cod_livro');
        return new DefaultResource($assunto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
