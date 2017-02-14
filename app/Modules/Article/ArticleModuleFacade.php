<?php 
namespace App\Modules\Article;
use Illuminate\Support\Facades\Facade;
use App\Modules\Article\Services\ArticleServiceInterface;

class ArticleModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return ArticleServiceInterface::class; }
    
}
