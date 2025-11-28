<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use Tms\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\Request;
use Tms\Traits\CommonTrait;
use Carbon\Carbon;
use Tms\Billing;

class ProfileController extends Controller
{
    use CommonTrait;
    //use \Illuminate\Foundation\Auth\ResetsPasswords;

    public function __construct(ProfileRepositoryInterface $profile)
    {
        $this->middleware('auth');
        $this->profile = $profile;
    }

    public function index()
    {
        $uid = $this->getUserID();
        $profile = $this->profile->view($uid);

        $created_at = Auth()->user()->created_at;

        $account_created = $created_at->format('Y-m-d');
        $trial_expires = $created_at->addDays(31)->format('Y-m-d');
        $payment_status = Billing::where('user_id', $uid)->first()->status;

        return view('tms.profile', compact('profile', 'account_created', 'payment_status', 'trial_expires'));
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

        $this->profile->store($this->getUserID(), $data);

        return redirect('/profile')->with('message', 'Profile updated!');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
                '_token' => 'required',
                'password' => 'required|min:6|confirmed'
            ]);

        $password = $request->input('password');

        $this->profile->resetPassword($this->getUserID(), $password);

        return redirect('/profile')->with('message', 'Password updated!');
    }
}
