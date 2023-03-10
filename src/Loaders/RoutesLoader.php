<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use Illuminate\Support\Facades\Route;

trait RoutesLoader
{
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
        $apiRoutes = $this->getApiRoutesFromContainers();
        $webRoutes = $this->getWebRoutesFromContainers();

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
}
