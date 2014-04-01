<?php namespace DigitalCanvas\LaravelPiwikTrackingApi;

use Illuminate\Support\ServiceProvider;
use PiwikTracker;

class LaravelPiwikTrackingApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('digital-canvas/laravel-piwik-tracking-api', 'piwik-tracking');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
      $this->app['piwik_tracker'] = $this->app->share(function($app)
        {
            $idSite = $app['config']->get('piwik-tracking::siteid');
            $url = $app['config']->get('piwik-tracking::url');
            $token = $app['config']->get('piwik-tracking::token');
            $tracker = new PiwikTracker( $idSite, $url);
            if ($token) {
                $tracker->setTokenAuth($token);
            }
            return $tracker;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
      return array('piwik_tracker');
	}

}
