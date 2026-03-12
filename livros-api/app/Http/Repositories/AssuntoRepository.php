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
        $arrSave = $request->except('livros_ids');
        $livrosIds = $request->input('livros_ids', []);
        $assunto = Assunto::create($arrSave);
        if (!empty($livrosIds)) {
            $assunto->livros()->sync($livrosIds);
        }
        // Retornar assunto com livros_ids para o frontend
        $assunto->load('livros');
        $assunto->livros_ids = $assunto->livros->pluck('cod_livro');
        return $assunto->fresh();
    }

    public function update(Request $request, $id)
    {
        $model = Assunto::find($id);
        $arrSave = $request->except('livros_ids');
        $livrosIds = $request->input('livros_ids', []);
        $model->update($arrSave);
        if (!empty($livrosIds)) {
            $model->livros()->sync($livrosIds);
        } else {
            $model->livros()->detach();
        }
        // Retornar assunto com livros_ids para o frontend
        $model->load('livros');
        $model->livros_ids = $model->livros->pluck('cod_livro');
        return $model;
    }

    public function find($id): Model|Collection|array|Assunto|null
    {
        return Assunto::find($id);
    }

    public function delete($id): int
    {
        return Assunto::destroy($id);
    }
}