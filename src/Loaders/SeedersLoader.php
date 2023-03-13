<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

trait SeedersLoader
{
    use FilesAndDirectories;

    /**
     * @return array
     */
    private function getSeedersFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Data'.DIRECTORY_SEPARATOR.'Seeders');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * @return array
     */
    private function getSeedersFromShip(): array
    {
        $directoryPath = config('porto.root').DIRECTORY_SEPARATOR.'Ship'.DIRECTORY_SEPARATOR.'Seeders';
        return $this->findFilesInDirectories($directoryPath);
    }

    /**
     * Load and call all seeders from ship and containers
     */
    private function loadSeedersAndCall()
    {
        $shipFiles = $this->getSeedersFromShip();
        $containersFiles = $this->getSeedersFromContainers();

        $files = array_merge($shipFiles, $containersFiles);

        foreach ($files as $file){
            $this->call($file);
        }
    }
}
