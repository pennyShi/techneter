<?php 
namespace App\Modules\User;
use Illuminate\Support\ServiceProvider;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserInfoRepository;
use App\Modules\User\Services\UserServiceInterface;
use App\Modules\User\Services\UserService;

class UserModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
		app()->bind(UserServiceInterface::class, UserService::class);
	}

}
