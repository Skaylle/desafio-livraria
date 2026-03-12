<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AutorRepository;
use App\Http\Requests\AutorRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\DefaultResource;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * @var AutorRepository
     */
    protected AutorRepository $repository;

    public function __construct()
    {
        $this->repository = new AutorRepository();
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
    public function store(AutorRequest $request)
    {
        return new DefaultResource($this->repository->create($request));
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(AutorRequest $request, Autor $Autor)
    {
        return new DefaultResource($this->repository->update($request, $Autor->cod_autor));
    }

    /**
     * Display the specified resource.
     */
    public function show(Autor $Autor)
    {
        return new DefaultResource($this->repository->find($Autor->cod_autor));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
