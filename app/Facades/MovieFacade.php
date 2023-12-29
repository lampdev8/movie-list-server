<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MovieFacade extends Facade
{
    public static function getFacadeAccessor()
	{
        return 'MovieFacade';
    }
}
