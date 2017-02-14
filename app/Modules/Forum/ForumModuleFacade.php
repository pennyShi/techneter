<?php 
namespace App\Modules\Forum;
use Illuminate\Support\Facades\Facade;
use App\Modules\Forum\Services\ForumServiceInterface;

class ForumModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return ForumServiceInterface::class; }
    
}
