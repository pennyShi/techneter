<?php 
namespace App\Modules\Ad;
use Illuminate\Support\Facades\Facade;
use App\Modules\Ad\Services\AdServiceInterface;

class AdModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return AdServiceInterface::class; }
    
}
