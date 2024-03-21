<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleMigrationGenerator;
use Illuminate\Session\Console\SessionTableCommand as LaravelSessionTableCommand;
use function Illuminate\Filesystem\join_paths;

class SessionTableCommand extends LaravelSessionTableCommand
{
    use ConsoleMigrationGenerator;

    /**
     * Determine whether a migration for the table already exists.
     *
     * @param  string  $table
     * @return bool
     */
    protected function migrationExists($table)
    {
        return count($this->files->glob(sprintf(
            '{%s,%s}',
            join_paths($this->laravel->databasePath('migrations'), '*_*_*_*_create_'.$table.'_table.php'),
            join_paths($this->laravel->databasePath('migrations'), '0001_01_01_000000_create_users_table.php'),
        ))) !== 0;
}
}
