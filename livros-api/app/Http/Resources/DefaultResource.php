<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class DefaultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        $routeName = $request->route()->getName();
        $isList = str_contains($routeName, '.index');
        $parent = parent::toArray($request);
        $arrCustom = [
            'data' => $this->resource,
            'success' => true,
            'message' => __('messages.request_success'),
        ];
        return $isList ? $parent : $arrCustom;
    }
}
