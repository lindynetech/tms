<?php

namespace Tms\Repositories;

interface VendorRepositoryInterface
{
    public function listAll();
    public function edit($id, $params);
    public function add($params);
    public function delete($id);
    public function getVendorsList();
    public function getVendorName($vid);
}
