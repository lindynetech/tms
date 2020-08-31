<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use Tms\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //use \Illuminate\Foundation\Auth\ResetsPasswords;

    public function __construct(ProfileRepositoryInterface $profile)
    {
        $this->middleware('auth');
        $this->profile = $profile;
        $this->userId = 1;
    }

    public function index()
    {
        $profile = $this->profile->view($this->userId);

        return view('tms.profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
            'email' => 'required|email',
            '_token' => 'required'
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ];

        $this->profile->store($this->userId, $data);

        return redirect('/profile')->with('message', 'Profile updated!');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
                '_token' => 'required',
                'password' => 'required|min:6|confirmed'
            ]);

        $password = $request->input('password');

        $this->profile->resetPassword($this->userId, $password);

        return redirect('/profile')->with('message', 'Password updated!');
    }
}
