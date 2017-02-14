<?php 
namespace App\Modules\Ad;
use Illuminate\Support\ServiceProvider;
use App\Modules\Ad\Services\AdServiceInterface;
use App\Modules\Ad\Repositories\Contracts\AdRepositoryInterface;
use App\Modules\Ad\Services\AdService;
use App\Modules\Ad\Repositories\Eloquents\AdRepository;

class AdModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	
	public function register()
	{
		app()->bind(AdRepositoryInterface::class, AdRepository::class);
		app()->bind(AdServiceInterface::class, AdService::class);
	}
}
