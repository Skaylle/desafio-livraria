<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Livro",
 *     title="Livro",
 *     description="Modelo de Livro",
 *     type="object",
 *     required={"titulo","editora","ano_publicacao","valor"},
 *     @OA\Property(property="cod_livro", type="integer", example=1, description="Código do livro"),
 *     @OA\Property(property="titulo", type="string", example="Dom Casmurro", description="Título do livro"),
 *     @OA\Property(property="editora", type="string", example="Editora Globo", description="Editora do livro"),
 *     @OA\Property(property="edicao", type="integer", example=2, description="Número da edição"),
 *     @OA\Property(property="ano_publicacao", type="string", example=1899, description="Ano de publicação"),
 *     @OA\Property(property="valor", type="number", format="float", example=39.90, description="Valor do livro"),
 *     @OA\Property(
 *         property="autores",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="Lista de autores"
 *     ),
 *     @OA\Property(
 *         property="assuntos",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="Lista de assuntos"
 *     )
 * )
 */
class Livro {}