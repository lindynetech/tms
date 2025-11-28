<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;

interface GoalRepositoryInterface
{
    public function listAll($userID, Request $request);
    public function listSingle($id);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
    public function getProperties($gid, $value);
    public function getProgress($gid);
}
