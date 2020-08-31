<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index() {
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
            $mess->from('saasdelivered@gmail.com', 'goalsland.com - Contact Message');
            $mess->replyTo($email);
            $mess->to('saasdelivered@gmail.com');
            $mess->subject('goalsland.com - '. $subject);
        });

        return 1;
    }

    public function privacypolicy() {
        return view('privacypolicy');
    }
}
