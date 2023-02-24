<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

trait ConfigsLoader
{
    use FilesAndDirectories;

    /**
     * @return array
     */
    private function getConfigsFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').'/Containers', 'Configs');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * @return array
     */
    private function getConfigsFromShip(): array
    {
        return $this->findFilesInDirectories(config('porto.root').'/Ship/Configs');
    }

    /**
     * @return array
     */
    private function getConfigsFromPackage(): array
    {
        return $this->findFilesInDirectories(__DIR__.'/../../config');
    }

    /**
     * Load configs from current package
     */
    protected function loadConfigsFromPackage(): void
    {
        $packageConfigs = $this->getConfigsFromPackage();
        foreach ($packageConfigs as $file){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $this->mergeConfigFrom($file, $filename);
        }
    }

    /**
     * Load and register configs
     */
    protected function loadConfigsForRegister(): void
    {
        $shipConfigs = $this->getConfigsFromShip();
        $containersConfigs = $this->getConfigsFromContainers();

        $configs = array_merge($shipConfigs, $containersConfigs);

        foreach ($configs as $file){
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $this->mergeConfigFrom($file, $filename);
        }
    }
}
