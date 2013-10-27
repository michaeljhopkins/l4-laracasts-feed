<?php namespace Malfaitrobin\Laracasts;

use Illuminate\Support\ServiceProvider;

class LaracastsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['laracasts'] = $this->app->share(function($app)
        {
                return new Laracasts($app['cache']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('laracasts');
	}

}
