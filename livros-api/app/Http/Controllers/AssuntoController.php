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
    /**
     * @OA\Get(
     *   path="/api/assuntos",
     *   summary="Lista todos os assuntos",
     *   tags={"Assuntos"},
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Número da página",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="descricao",
     *     in="query",
     *     description="Filtrar pela descrição do assunto",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lista de assuntos",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Assunto")),
     *       @OA\Property(property="meta", type="object")
     *     )
     *   )
     * )
     */
    public function index(Request $request): DefaultCollection
    {
        return new DefaultCollection($this->repository->paginate($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *   path="/api/assuntos",
     *   summary="Cadastra um novo assunto",
     *   tags={"Assuntos"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Assunto")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Assunto cadastrado",
     *     @OA\JsonContent(ref="#/components/schemas/Assunto")
     *   )
     * )
     */
    public function store(AssuntoRequest $request)
    {
        $assunto = $this->repository->create($request);
        $assunto->livros_ids = $assunto->livros->pluck('cod_livro');
        return new DefaultResource($assunto);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *   path="/api/assuntos/{id}",
     *   summary="Atualiza um assunto",
     *   tags={"Assuntos"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Assunto")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Assunto atualizado",
     *     @OA\JsonContent(ref="#/components/schemas/Assunto")
     *   )
     * )
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
    /**
     * @OA\Get(
     *   path="/api/assuntos/{id}",
     *   summary="Exibe um assunto",
     *   tags={"Assuntos"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Assunto encontrado",
     *     @OA\JsonContent(ref="#/components/schemas/Assunto")
     *   )
     * )
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
    /**
     * @OA\Delete(
     *   path="/api/assuntos/{id}",
     *   summary="Remove um assunto",
     *   tags={"Assuntos"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Assunto removido",
     *     @OA\JsonContent(type="object", @OA\Property(property="success", type="boolean"))
     *   )
     * )
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
