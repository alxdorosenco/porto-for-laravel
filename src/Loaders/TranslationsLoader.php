<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

trait TranslationsLoader
{
    use FilesAndDirectories;

    /**
     * @return string|null
     */
    private function getTranslationsFromShip(): ?string
    {
        return $this->findExistingDirectory(config('porto.root').DIRECTORY_SEPARATOR.'Ship'.DIRECTORY_SEPARATOR.'Translations');
    }

    /**
     * @return array
     */
    private function getTranslationsFromContainers(): array
    {
        return $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Translations');
    }

    /**
     * Load migration for boot in the provider
     */
    protected function loadTranslationsForBoot(): void
    {
        $shipDirectory = $this->getTranslationsFromShip();
        $containersDirectories = $this->getTranslationsFromContainers();

        if ($shipDirectory){
            $this->loadTranslationsFrom($shipDirectory,'ship');
            $this->loadJsonTranslationsFrom($shipDirectory);
        }

        foreach ($containersDirectories as $directory){
            $containerNameArray = $this->findAndChainBetween($directory, 'Containers', '(Translations)');
            if(!$containerNameArray){
                continue;
            }

            $containerName = end($containerNameArray);
            $containerName = str_replace(DIRECTORY_SEPARATOR,'@', $containerName);

            $this->loadTranslationsFrom($directory, strtolower($containerName));
            $this->loadJsonTranslationsFrom($directory);
        }
    }
}
