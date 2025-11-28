<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Tms\Billing;

class HandleFreeTrialExp
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  LoggedIn  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $created = $user->created_at;
        $trial_expires = $created->addDays(31);
        $now = Carbon::now();

        if($now->gt($trial_expires)) {
            // Trial Expired
            $bill = Billing::where('user_id', $user->id)->first();
            $bill->status = 'Not Subscribed';
            $bill->save();
        }
    }
}
