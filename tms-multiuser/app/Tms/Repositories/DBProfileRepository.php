<?php

namespace Tms\Repositories;

use Tms\Repositories\ProfileRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Auth;

class DBProfileRepository implements ProfileRepositoryInterface
{
    public function view($userId)
    {
        $profile = User::where('id', $userId)->get()->toArray();
        return $profile[0];
    }

    public function store($userId, array $data)
    {
        list($name, $email) = array_values($data);
        $user = User::findOrFail($userId);

        $user->name = $name;
        $user->email = $email;

        $user->save();
    }

    public function resetPassword($userId, $password)
    {
        $user = User::findOrFail($userId);
        $user->password = bcrypt($password);

        $user->save();
    }
}
