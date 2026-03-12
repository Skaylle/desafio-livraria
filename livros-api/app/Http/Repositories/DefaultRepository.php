<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;

class DefaultRepository
{
    protected int $page = 1;
    protected int $limit = 10;
    protected ?string $orderBy = null;
    protected string $order = 'desc';
    protected ?string $search = null;

    protected function getPaginateParams(Request $request): array
    {
        return [
            'page' => $request->get('page', $this->page),
            'limit' => $request->get('limit', $this->limit),
            'order_by' => $request->get('order_by', $this->orderBy),
            'order' => $request->get('order', $this->order),
            'search' => $request->get('search', $this->search),
        ];
    }    
}
