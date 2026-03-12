<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Autor",
 *     title="Autor",
 *     description="Modelo de Autor",
 *     type="object",
 *     required={"nome"},
 *     @OA\Property(property="cod_autor", type="integer", example=1, description="Código do autor"),
 *     @OA\Property(property="nome", type="string", example="Machado de Assis", description="Nome do autor"),
 *     @OA\Property(
 *         property="livros",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="Lista de livros do autor"
 *     )
 * )
 */
class Autor {}
