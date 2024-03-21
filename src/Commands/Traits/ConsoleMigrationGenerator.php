<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Traits;

use function Illuminate\Filesystem\join_paths;

trait ConsoleMigrationGenerator
{
    use Console;

    /**
     * @param $table
     * @return string
     */
    protected function createBaseMigration($table)
    {
        return $this->laravel['migration.creator']->create(
            'create_'.$table.'_table', $this->getNecessaryNamespace().'\Migrations'
        );
    }

    /**
     * Determine whether a migration for the table already exists.
     *
     * @param  string  $table
     * @return bool
     */
    protected function migrationExists($table)
    {
        return count($this->files->glob(
            join_paths($this->getNecessaryNamespace().'\Migrations', '*_*_*_*_create_'.$table.'_table.php')
        )) !== 0;
    }
}
