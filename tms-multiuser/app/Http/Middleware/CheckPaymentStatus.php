<?php

namespace App\Http\Middleware;

use Closure;
use Tms\Billing;

class CheckPaymentStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uid = $request->user()->id;
        $bill = Billing::where('user_id', $uid)->first();

        if ($bill->status == 'Not Subscribed') {
            return redirect('/profile')->with('message', 'Your free trial has expired. Please subscribe!');
        }
        return $next($request);
    }
}
