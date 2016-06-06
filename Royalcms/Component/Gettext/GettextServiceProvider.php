<?php namespace Royalcms\Component\Gettext;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Laravel gettext main service provider
 */
class LaravelGettextServiceProvider extends ServiceProvider
{
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
    {}

    /**
     * Register the service provider.
     *
     * @return mixed
     */
    public function register()
    {
        $this->royalcms->bind('Adapters/AdapterInterface', 'Adapters/RoyalcmsAdapter');

        // Main class register 
        $this->royalcms['gettext'] = $this->royalcms->share(function ($royalcms) {

            $configuration = Config\ConfigManager::create();

            $fileSystem = new FileSystem($configuration->get(), app_path(), storage_path());

            $gettext = new RoyalcmsGettext(
                $configuration->get(),
                new Session\SessionHandler,
                new Adapters\RoyalcmsAdapter,
                $fileSystem
            );

            return new Gettext($gettext);
        });

        // Auto alias 
        $this->royalcms->booting(function () {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('Gettext',
                'Royalcms\Component\Gettext\Facades\Gettext');
            $loader->alias('RC_Gettext',
                'Royalcms\Component\Gettext\Facades\Gettext');
        });

        // Package commands
        $this->royalcms->bind('gettext.create', function ($royalcms) {
            return new Commands\GettextCreate();
        });
        $this->royalcms->bind('gettext.update', function ($royalcms) {
            return new Commands\GettextUpdate();
        });
        $this->commands(array(
            'gettext.create',
            'gettext.update',
        ));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('gettext');
    }
}

