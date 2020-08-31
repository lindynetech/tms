<?php

namespace Tms\Repositories;

interface DailyGoalRepositoryInterface
{
    public function listAll($userID);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
    public function flush();
}
