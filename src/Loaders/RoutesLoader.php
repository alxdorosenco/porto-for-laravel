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
            $containerNameArray = $this->findAndChainBetween($route, 'Containers', '(UI)(\\\\|\/)(API)(\\\\|\/)(Routes)');
            if(empty($containerNameArray[0])){
                continue;
            }

            $namespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$containerNameArray[0].'/UI/API/Controllers');

            Route::middleware('api')
                ->prefix('api')
                ->namespace($namespace)
                ->group($route);
        }

        foreach ($webRoutes as $route){
            $containerNameArray = $this->findAndChainBetween($route, 'Containers', '(UI)(\\\\|\/)(WEB)(\\\\|\/)(Routes)');
            if(empty($containerNameArray[0])){
                continue;
            }

            $namespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$containerNameArray[0].'/UI/WEB/Controllers');

            Route::middleware('web')
                ->namespace($namespace)
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
