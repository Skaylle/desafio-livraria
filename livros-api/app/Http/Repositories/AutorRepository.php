<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\RepositoryInterface;
use App\Models\Autor;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AutorRepository extends DefaultRepository implements RepositoryInterface
{
    public function paginate(Request $request)
    {
        $this->orderBy = Autor::getDefaultOrderBy();

        $params = $this->getPaginateParams($request);
        $params['nome'] = $request->get('nome', null);

        $listPaginated = Autor::orderBy($params['order_by'], $params['order']);
        $listPaginated->where(function ($query) use ($params) {
            if ($params['nome']) {
                $query->where('nome', '=', $params['nome']);
            }
        });

        return $listPaginated->paginate($params['limit'], ['*'], 'page', $params['page'])->appends($params);
    }

    public function all(): Collection
    {
        return Autor::all();
    }

    public function create(Request $request)
    {
        $arrSave = $request->all();

        $autor = Autor::create($arrSave);

        if (!empty($request->get('selectedLivros'))) {
            $autor->livros()->attach($request->get('selectedLivros'));
        }

        return  $autor->load('livros');
    }

    public function update(Request $request, $id)
    {
        $model = Autor::find($id);
        $arrSave = $request->all();

        $model->update($arrSave);

        if (!empty($request->get('selectedLivros'))) {
            $model->livros()->sync($request->get('selectedLivros'));
        }

        return $model->load('livros');
    }

    public function find($id): Model|Collection|array|Autor|null
    {
        return Autor::with('livros')->find($id);
    }

    public function delete($id): int
    {
        return Autor::destroy($id);
    }
}