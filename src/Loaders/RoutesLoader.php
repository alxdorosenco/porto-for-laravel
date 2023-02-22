<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Closure;

trait RoutesLoader
{
    use FilesAndDirectories;

    /**
     * @return array
     */
    private function getApiRoutesFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'UI'.DIRECTORY_SEPARATOR.'API'.DIRECTORY_SEPARATOR.'Routes');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * @return array
     */
    private function getWebRoutesFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'UI'.DIRECTORY_SEPARATOR.'WEB'.DIRECTORY_SEPARATOR.'Routes');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * @return array
     */
    private function getCliRoutesFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'UI'.DIRECTORY_SEPARATOR.'CLI'.DIRECTORY_SEPARATOR.'Routes');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * Load web and api routes for the ServiceProvider
     */
    protected function loadRoutesForBoot(): void
    {
        $this->configureRateLimiting();
        $apiRoutes = $this->getApiRoutesFromContainers();
        $webRoutes = $this->getWebRoutesFromContainers();

        $this->routes(function () use ($apiRoutes, $webRoutes) {
                foreach ($apiRoutes as $route){
                    Route::middleware('api')
                        ->prefix('api')
                        ->group($route);
                }

                foreach ($webRoutes as $route){
                    Route::middleware('web')
                        ->group($route);
                }
            }
        );
    }

    /**
     * Load cli routes for the ConsoleKernel
     */
    protected function loadRoutesForConsoleKernel(): void
    {
        $consoleRoutes = $this->getCliRoutesFromContainers();

        foreach ($consoleRoutes as $route){
            require $route;
        }
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    protected function routes(Closure $callback): mixed
    {
        return $this->app->call($callback);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
