<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleKernel;

trait CommandsLoader
{
    use ConsoleKernel;

    /**
     * @return array
     */
    private function getCommandsFromContainers(): array
    {
        return $this->findDirectories(config('porto.root'), 'CLI'.DIRECTORY_SEPARATOR.'Commands');
    }

    /**
     * @return string
     */
    private function getCommandsFromShip(): string
    {
        return config('porto.root').DIRECTORY_SEPARATOR.'Commands';
    }

    /**
     * Load commands for the ConsoleKernel
     */
    protected function loadCommandsForConsoleKernel(): void
    {
        $this->load($this->getCommandsFromShip());

        foreach ($this->getCommandsFromContainers() as $directory){
            $this->load($directory);
        }
    }

    /**
     * Load commands from the package
     */
    protected function loadCommandsForRegister(): void
    {
        $commandFiles = $this->findFilesInDirectories([
            __DIR__.'/../Commands',
            __DIR__.'/../Commands/Generators',
            __DIR__.'/../Commands/Models'
        ]);

        $commandClasses = [];
        foreach ($commandFiles as $file){
            $commandClasses[] = $this->getClassFromFile($file);
        }

        $this->commands($commandClasses);
    }
}
