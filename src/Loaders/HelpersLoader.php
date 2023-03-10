<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

trait HelpersLoader
{
    /**
     * @return array
     */
    private function getHelpersFromShip(): array
    {
        $directoryPath = config('porto.root').DIRECTORY_SEPARATOR.'Ship'.DIRECTORY_SEPARATOR.'Helpers';
        return $this->findFilesInDirectories($directoryPath);
    }

    /**
     * @return array
     */
    private function getHelpersFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Helpers');
        return $this->findFilesInDirectories($directories);
    }

    /**
     * Load helpers from ship and containers
     */
    protected function loadHelpersForBoot(): void
    {
        $shipFiles = $this->getHelpersFromShip();
        $containersFiles = $this->getHelpersFromContainers();

        $files = array_merge($shipFiles, $containersFiles);

        foreach ($files as $file){
            require $file;
        }
    }
}
