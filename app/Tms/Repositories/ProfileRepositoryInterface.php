<?php

namespace Tms\Repositories;

interface ProfileRepositoryInterface
{
    public function view($userId);
    public function store($userId, array $data);
    public function resetPassword($userId, $password);
}
