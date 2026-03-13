<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\RepositoryInterface;
use App\Models\Assunto;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssuntoRepository extends DefaultRepository implements RepositoryInterface
{
    public function paginate(Request $request)
    {
        $this->orderBy = Assunto::getDefaultOrderBy();

        $params = $this->getPaginateParams($request);
        $params['descricao'] = $request->get('descricao', null);

        $listPaginated = Assunto::orderBy($params['order_by'], $params['order']);
        $listPaginated->where(function ($query) use ($params) {
            if ($params['descricao']) {
                $query->where('descricao', 'like', "%{$params['descricao']}%");
            }
        });

        return $listPaginated->paginate($params['limit'], ['*'], 'page', $params['page'])->appends($params);
    }

    public function all(): Collection
    {
        return Assunto::all();
    }

    public function create(Request $request)
    {
        $arrSave = $request->all();

        $assunto = Assunto::create($arrSave);

        if(!empty($request->get('selectedLivros'))) {
            $assunto->livros()->attach($request->get('selectedLivros'));
        }

        return $assunto->load('livros');
    }

    public function update(Request $request, $id)
    {
        $assunto = Assunto::find($id);
        $arrSave = $request->all();

        $assunto->update($arrSave);

        if(!empty($request->get('selectedLivros'))) {
            $assunto->livros()->sync($request->get('selectedLivros'));
        }

        return $assunto->load('livros');
    }

    public function find($id): Model|Collection|array|Assunto|null
    {
        return Assunto::with('livros')->find($id);
    }

    public function delete($id): int
    {
        return Assunto::destroy($id);
    }
}