<?php

namespace Tms\Repositories;

interface MindstormIdeasRepositoryInterface
{
    public function listAll($id);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
}
