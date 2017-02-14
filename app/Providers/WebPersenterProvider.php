<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Presenters\Contracts\WebPersenterInterface;
use App\Presenters\Eloquent\WebPersenter;

class WebPersenterProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(WebPersenterInterface::class, WebPersenter::class);	
	}

}
