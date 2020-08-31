<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function listAll($id, VendorRepositoryInterface $vendor, Request $request);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
    public function listSubtasks($id);
    public function editSubtask($id, $params);
    public function addSubtask($params);
    public function deleteSubtask($id);
    public function listUncompleted($gid);
}
