<?php namespace CodeZero\OAuth\Laravel5;

use CodeZero\OAuth\ProviderFactory;
use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->setPublishPaths();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthenticator();
        $this->registerProviderFactory();
    }

    /**
     * Set publish paths.
     *
     * @return void
     */
    private function setPublishPaths()
    {
        $this->publishes([
            __DIR__.'/../providers.php' => config_path('oauth-providers.php'),
        ]);
    }

    /**
     * Register the authenticator.
     *
     * @return void
     */
    public function registerAuthenticator()
    {
        $this->app->bind('CodeZero\OAuth\Contracts\Authenticator', 'CodeZero\OAuth\Authenticator');
    }

    /**
     * Register the provider factory.
     *
     * @return void
     */
    public function registerProviderFactory()
    {
        $this->app->bind('CodeZero\OAuth\Contracts\ProviderFactory', function () {
            $providers = config('oauth-providers') ?: [];
            return new ProviderFactory($providers);
        });
    }
}
