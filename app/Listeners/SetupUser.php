<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tms\Vendor;
use Tms\Billing;

class SetupUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Add user to Vendors List

        $vendor = new Vendor();
        
        $vendor->name = $event->user->name;
        /*$vendor->role = 'Assignee'; // Will populate with default values
        $vendor->status = 'Active';*/
        $vendor->contact = $event->user->email;
        $vendor->user_id = $event->user->id;

        $vendor->save();

        // Start Free Trial

        $bill = new Billing();

        $bill->user_id = $event->user->id;
        $bill->status = 'Free Trial';

        $bill->save();
    }
}
