<?php namespace Hpkns\FrontMatter;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Parser as Yaml;

class LaravelFrontMatterServiceProvider extends ServiceProvider {

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
        $this->app->bindShared('front-matter', function(){
            return new Parser(new Yaml);
        });
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
