<?php 
namespace App\Modules\Article;
use Illuminate\Support\ServiceProvider;
use App\Modules\Article\Repositories\Contracts\ArticleCategoryRepositoryInterface;
use App\Modules\Article\Repositories\Eloquents\ArticleCategoryRepository;
use App\Modules\Article\Repositories\Contracts\ArticleRepositoryInterface;
use App\Modules\Article\Repositories\Eloquents\ArticleRepository;
use App\Modules\Article\Services\ArticleServiceInterface;
use App\Modules\Article\Services\ArticleService;

class ArticleModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(ArticleCategoryRepositoryInterface::class, ArticleCategoryRepository::class);
		app()->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
		app()->bind(ArticleServiceInterface::class, ArticleService::class);
	}

}
