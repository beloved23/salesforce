<?php
namespace App\Facades\MyFacades;
use Illuminate\Support\Facades\Facade;

class QuickTaskFacade extends Facade{
    protected static function getFacadeAccessor() { return 'test'; }
 }
?>