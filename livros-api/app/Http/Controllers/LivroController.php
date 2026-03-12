<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LivroRepository;
use App\Http\Requests\LivroRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\DefaultResource;
use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * @var LivroRepository
     */
    protected LivroRepository $repository;

    public function __construct()
    {
        $this->repository = new LivroRepository();
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
    public function store(LivroRequest $request)
    {
        return new DefaultResource($this->repository->create($request));
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(LivroRequest $request, Livro $livro)
    {
        return new DefaultResource($this->repository->update($request, $livro->cod_livro));
    }

    /**
     * Display the specified resource.
     */
    public function show(Livro $livro)
    {
        return new DefaultResource($this->repository->find($livro->cod_livro));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
