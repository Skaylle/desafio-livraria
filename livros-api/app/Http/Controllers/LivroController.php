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
    /**
     * @OA\Get(
     *   path="/api/livros",
     *   summary="Lista todos os livros",
     *   tags={"Livros"},
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Número da página",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="titulo",
     *     in="query",
     *     description="Filtrar pelo título do livro",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="editora",
     *     in="query",
     *     description="Filtrar pela editora do livro",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="edicao",
     *     in="query",
     *     description="Filtrar pelo número da edição",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="ano_publicacao",
     *     in="query",
     *     description="Filtrar pelo ano de publicação",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lista de livros",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Livro")),
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
     *   path="/api/livros",
     *   summary="Cadastra um novo livro",
     *   tags={"Livros"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Livro")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Livro cadastrado",
     *     @OA\JsonContent(ref="#/components/schemas/Livro")
     *   )
     * )
     */
    public function store(LivroRequest $request)
    {
        return new DefaultResource($this->repository->create($request));
    }

     /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *   path="/api/livros/{id}",
     *   summary="Atualiza um livro",
     *   tags={"Livros"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Livro")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Livro atualizado",
     *     @OA\JsonContent(ref="#/components/schemas/Livro")
     *   )
     * )
     */
    public function update(LivroRequest $request, Livro $livro)
    {
        return new DefaultResource($this->repository->update($request, $livro->cod_livro));
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *   path="/api/livros/{id}",
     *   summary="Exibe um livro",
     *   tags={"Livros"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Livro encontrado",
     *     @OA\JsonContent(ref="#/components/schemas/Livro")
     *   )
     * )
     */
    public function show(Livro $livro)
    {
        return new DefaultResource($this->repository->find($livro->cod_livro));
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *   path="/api/livros/{id}",
     *   summary="Remove um livro",
     *   tags={"Livros"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Livro removido",
     *     @OA\JsonContent(type="object", @OA\Property(property="success", type="boolean"))
     *   )
     * )
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
