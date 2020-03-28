<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Oss extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OSS';
    }
}
