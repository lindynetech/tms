<?php

namespace Tms\Repositories;

interface VendorRepositoryInterface
{
    public function listAll($userID);
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
    public function getVendorsList($userID);
    public function getVendorName($vid);
}
