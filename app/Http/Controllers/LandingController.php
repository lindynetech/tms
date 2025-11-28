<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index() {
        // Redirect to app if branding is disabled
        if (config('tms.branding') === '0') {
            return redirect('/app');
        }
        return view('landing');
    }

    public function contact(Request $request) {
        //return 1;

        $this->validate($request, [
            'name' => 'required|max:40',
            'email' => 'required|email',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
            '_token' => 'required',
            /*'g-recaptcha-response' => 'required|captcha',*/
        ]);

        $email = $request->input('email');
        $subject = $request->input('subject');

        $data = [
            'name' => $request->input('name'),
            'email' => $email,
            'subject' => $subject,
            'bodymessage' => $request->input('message')
        ];

        \Mail::send('contacttemplate', $data, function ($mess) use ($email, $subject) {
            $mess->from(env('APP_ADMIN_EMAIL', 'admin@localhost'), env('APP_DOMAIN', 'localhost') . ' - Contact Message');
            $mess->replyTo($email);
            $mess->to(env('APP_ADMIN_EMAIL', 'admin@localhost'));
            $mess->subject(env('APP_DOMAIN', 'localhost') . ' - '. $subject);
        });

        return 1;
    }

    public function privacypolicy() {
        return view('privacypolicy');
    }
}
