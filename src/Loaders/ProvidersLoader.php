<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Support\Facades\App;

trait ProvidersLoader
{
    use FilesAndDirectories;

    private function getProvidersFromShip(): array
    {
        $files = $this->findFilesInDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Ship');

        $classesProviders = [];
        foreach ($files as $file){
            $classProvider = $this->getClassFromFile($file);
            !class_exists($classProvider) ?: $classesProviders[] = $classProvider;
        }

        return $classesProviders;
    }

    /**
     * @return array
     */
    private function getProvidersFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Providers');
        $files = $this->findFilesInDirectories($directories);

        $classesProviders = [];
        foreach ($files as $file){
            $classProvider = $this->getClassFromFile($file);
            !class_exists($classProvider) ?: $classesProviders[] = $classProvider;
        }

        return $classesProviders;
    }

    /**
     * @return array
     */
    private function getProvidersFromContainersLoaders(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Loaders');

        $providers = [];
        foreach ($directories as $directory){
            $classLoader = $this->getClassFromFile($directory.DIRECTORY_SEPARATOR.'ProvidersLoader.php');
            !class_exists($classLoader) ?: app($classLoader)->providers;
        }

        return $providers;
    }

    /**
     * Load registered application, custom and containers providers
     */
    protected function loadProvidersForRegister(): void
    {
        /**
         * Load and register providers from the ship
         */
        $shipProviders = $this->getProvidersFromShip();

        /**
         * Load and register providers from the containers
         * If we cannot find array of providers in the containers loaders
         * providers would be loaded automatically from the Providers directory
         */
        $containersProviders = $this->getProvidersFromContainersLoaders();

        if(!$containersProviders){
            $containersProviders = $this->getProvidersFromContainers();
        }

        $providers = array_merge($shipProviders, $containersProviders);

        foreach ($providers as $provider){
            App::register($provider);
        }
    }
}
