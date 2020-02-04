<?php
namespace App\Facades\MyFacades;

use Illuminate\Support\Facades\Facade;

class VacancyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'vacancy';
    }
}
