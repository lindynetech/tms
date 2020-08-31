<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;

interface ReadinglistRepositoryInterface
{
    public function listAll(Request $request);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
}
