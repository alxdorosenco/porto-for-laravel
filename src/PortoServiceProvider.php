<?php

namespace AlxDorosenco\PortoForLaravel;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Support\ServiceProvider;

use AlxDorosenco\PortoForLaravel\Loaders\ConfigsLoader;
use AlxDorosenco\PortoForLaravel\Loaders\RoutesLoader;
use AlxDorosenco\PortoForLaravel\Loaders\TranslationsLoader;
use AlxDorosenco\PortoForLaravel\Loaders\MigrationsLoader;
use AlxDorosenco\PortoForLaravel\Loaders\MiddlewareLoader;
use AlxDorosenco\PortoForLaravel\Loaders\AliasesLoader;
use AlxDorosenco\PortoForLaravel\Loaders\ViewsLoader;
use AlxDorosenco\PortoForLaravel\Loaders\ProvidersLoader;
use AlxDorosenco\PortoForLaravel\Loaders\HelpersLoader;
use AlxDorosenco\PortoForLaravel\Loaders\CommandsLoader;

class PortoServiceProvider extends ServiceProvider
{
    use FilesAndDirectories;
    use ConfigsLoader;
    use RoutesLoader;
    use TranslationsLoader;
    use MigrationsLoader;
    use MiddlewareLoader;
    use AliasesLoader;
    use ViewsLoader;
    use ProvidersLoader;
    use HelpersLoader;
    use CommandsLoader;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfigsFromPackage();

        if(config('porto.enabled')){
            $this->loadConfigsForRegister();
            $this->loadProvidersForRegister();
            $this->loadAliasesForRegister();
            $this->loadMiddlewareForRegister();
            $this->loadCommandsForRegister();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('porto.enabled')){
            $this->loadRoutesForBoot();
            $this->loadTranslationsForBoot();
            $this->loadHelpersForBoot();
            $this->loadMigrationsForBoot();
            $this->loadViewsForBoot();
        }
    }
}
