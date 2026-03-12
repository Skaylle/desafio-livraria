<?php

namespace App\Http\Repositories\Interfaces;

use Illuminate\Http\Request;

interface RepositoryInterface
{

    public function paginate(Request $request);

    public function all();

    public function find($id);

    public function create(Request $request);

    public function update(Request $request, $id);

    public function delete($id);
}
