<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\RepositoryInterface;
use App\Models\Livro;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LivroRepository extends DefaultRepository implements RepositoryInterface
{
    public function paginate(Request $request)
    {
        $this->orderBy = Livro::getDefaultOrderBy();

        $params = $this->getPaginateParams($request);
        $params['titulo'] = $request->get('titulo', null);
        $params['editora'] = $request->get('editora', null);
        $params['edicao'] = $request->get('edicao', null);
        $params['ano_publicacao'] = $request->get('ano_publicacao', null);

        $listPaginated = Livro::orderBy($params['order_by'], $params['order']);
        $listPaginated->where(function ($query) use ($params) {
            if ($params['titulo']) {
                $query->where('titulo', '=', $params['titulo']);
            }
            if ($params['editora']) {
                $query->where('editora', '=', $params['editora']);
            }
            if ($params['edicao']) {
                $query->where('edicao', '=', $params['edicao']);
            }
             if ($params['ano_publicacao']) {
                $query->where('ano_publicacao', '=', $params['ano_publicacao']);
            }
        });

        return $listPaginated->paginate($params['limit'], ['*'], 'page', $params['page'])->appends($params);
    }

    public function all(): Collection
    {
        return Livro::all();
    }

    public function create(Request $request)
    {
        $arrSave = $request->all();

        $livro = Livro::create($arrSave);

        if (!empty($request->get('selectedAuthors'))) {
            $livro->autores()->attach($request->get('selectedAuthors'));
        }
        if (!empty($request->get('selectedAssuntos'))) {
            $livro->assuntos()->attach($request->get('selectedAssuntos'));
        }

        return  $livro->load(['autores', 'assuntos']);
    }

    public function update(Request $request, $id)
    {
        $model = Livro::find($id);
        $arrSave = $request->all();

        $model->update($arrSave);

        if (!empty($request->get('selectedAuthors'))) {
            $model->autores()->sync($request->get('selectedAuthors'));
        }
        if (!empty($request->get('selectedAssuntos'))) {
            $model->assuntos()->sync($request->get('selectedAssuntos'));
        }

        return $model->load(['autores', 'assuntos']);
    }

    public function find($id): Model|Collection|array|Livro|null
    {
        return Livro::with(['autores', 'assuntos'])->find($id);
    }

    public function delete($id): int
    {
        return Livro::destroy($id);
    }
}