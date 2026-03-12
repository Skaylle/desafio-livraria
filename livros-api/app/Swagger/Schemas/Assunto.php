<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Assunto",
 *     title="Assunto",
 *     description="Modelo de Assunto",
 *     type="object",
 *     required={"descricao"},
 *     @OA\Property(property="cod_assunto", type="integer", example=1, description="Código do assunto"),
 *     @OA\Property(property="descricao", type="string", example="Literatura Brasileira", description="Descrição do assunto"),
 *     @OA\Property(
 *         property="livros",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="Lista de livros relacionados ao assunto"
 *     )
 * )
 */
class Assunto {}
