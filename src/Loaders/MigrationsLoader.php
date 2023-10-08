<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

trait MigrationsLoader
{
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

        $migrations = array_merge($containersMigrations, [$shipMigrations]);

        $this->loadMigrationsFrom($migrations);
    }
}
