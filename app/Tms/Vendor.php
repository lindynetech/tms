<?php

namespace Tms;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'role', 'status', 'contact'];
}
