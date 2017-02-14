<?php 
namespace App\Modules\Forum;
use Illuminate\Support\ServiceProvider;
use App\Modules\Forum\Repositories\Contracts\ForumCategoryRepositoryInterface;
use App\Modules\Forum\Repositories\Eloquents\ForumCategoryRepository;
use App\Modules\Forum\Repositories\Contracts\ForumPostRepositoryInterface;
use App\Modules\Forum\Repositories\Eloquents\ForumPostRepository;
use App\Modules\Forum\Repositories\Contracts\ForumReplyRepositoryInterface;
use App\Modules\Forum\Repositories\Eloquents\ForumReplyRepository;
use App\Modules\Forum\Repositories\Contracts\ForumPostPraiseRepositoryInterface;
use App\Modules\Forum\Repositories\Eloquents\ForumPostPraiseRepository;
use App\Modules\Forum\Services\ForumServiceInterface;
use App\Modules\Forum\Services\ForumService;

class ForumModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(ForumCategoryRepositoryInterface::class, ForumCategoryRepository::class);
		app()->bind(ForumPostRepositoryInterface::class, ForumPostRepository::class);
		app()->bind(ForumReplyRepositoryInterface::class, ForumReplyRepository::class);
		app()->bind(ForumPostPraiseRepositoryInterface::class, ForumPostPraiseRepository::class);
		app()->bind(ForumServiceInterface::class, ForumService::class);
	}

}
