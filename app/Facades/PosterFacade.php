<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PosterFacade extends Facade
{
    public static function getFacadeAccessor()
	{
        return 'PosterFacade';
    }
}
