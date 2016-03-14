<?php namespace Hpkns\FrontMatter;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Parser as Yaml;

class FrontMatterServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('front-matter', Parser::class);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['front-matter'];
	}

}
