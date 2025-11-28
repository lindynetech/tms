<?php

namespace Tms\Repositories;

interface ReadinglistNotesRepositoryInterface
{
    public function listAll($bid);
    public function edit($params);
    public function add($params);
    public function delete($id);
}
