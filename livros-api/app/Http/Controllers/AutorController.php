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
    /**
    * @OA\Get(
    *   path="/autors",
     *   summary="Lista todos os autores",
     *   tags={"Autores"},
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Número da página",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="nome",
     *     in="query",
     *     description="Filtrar pelo nome do autor",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lista de autores",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Autor")),
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
    *   path="/autors",
     *   summary="Cadastra um novo autor",
     *   tags={"Autores"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Autor")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Autor cadastrado",
     *     @OA\JsonContent(ref="#/components/schemas/Autor")
     *   )
     * )
     */
    public function store(AutorRequest $request)
    {
        return new DefaultResource($this->repository->create($request));
    }

     /**
     * Update the specified resource in storage.
     */
    /**
    * @OA\Put(
    *   path="/autors/{id}",
     *   summary="Atualiza um autor",
     *   tags={"Autores"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Autor")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Autor atualizado",
     *     @OA\JsonContent(ref="#/components/schemas/Autor")
     *   )
     * )
     */
    public function update(AutorRequest $request, Autor $Autor)
    {
        return new DefaultResource($this->repository->update($request, $Autor->cod_autor));
    }

    /**
     * Display the specified resource.
     */
    /**
    * @OA\Get(
    *   path="/autors/{id}",
     *   summary="Exibe um autor",
     *   tags={"Autores"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Autor encontrado",
     *     @OA\JsonContent(ref="#/components/schemas/Autor")
     *   )
     * )
     */
    public function show(Autor $Autor)
    {
        return new DefaultResource($this->repository->find($Autor->cod_autor));
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
    * @OA\Delete(
    *   path="/autors/{id}",
     *   summary="Remove um autor",
     *   tags={"Autores"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Autor removido",
     *     @OA\JsonContent(type="object", @OA\Property(property="success", type="boolean"))
     *   )
     * )
     */
    public function destroy(string $id): array
    {
        return ['success' => $this->repository->delete($id)];
    }
}
