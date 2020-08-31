<?php

namespace Tms\Traits;

use Auth;

trait Commontrait 
{
	public function getUserID(){
        return Auth()->user()->id;
    }
}