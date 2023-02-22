<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

trait MigrationsLoader
{
    use FilesAndDirectories;

    /**
     * @return string
     */
    private function getMigrationsFromShip(): string
    {
        return config('porto.root').DIRECTORY_SEPARATOR.'Ship'.DIRECTORY_SEPARATOR.'Migrations';
    }

    /**
     * @return array
     */
    private function getMigrationsFromContainers(): array
    {
        return $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers','Data'.DIRECTORY_SEPARATOR.'Migrations');
    }

    /**
     * Load migration for boot in the provider
     */
    protected function loadMigrationsForBoot(): void
    {
        $shipMigrations = $this->getMigrationsFromShip();
        $containersMigrations = $this->getMigrationsFromContainers();

        $migrations = $containersMigrations + [$shipMigrations];

        $this->loadMigrationsFrom($migrations);
    }
}
