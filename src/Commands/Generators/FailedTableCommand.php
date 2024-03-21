<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Queue\Console\FailedTableCommand as LaravelFailedTableCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleMigrationGenerator;
use function Illuminate\Filesystem\join_paths;

class FailedTableCommand extends LaravelFailedTableCommand
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
        if ($table !== 'failed_jobs') {
            return parent::migrationExists($table);
        }

        return count($this->files->glob(sprintf(
            '{%s,%s}',
            join_paths($this->getNecessaryNamespace().'\Migrations', '*_*_*_*_create_'.$table.'_table.php'),
            join_paths($this->getNecessaryNamespace().'\Migrations', '0001_01_01_000002_create_jobs_table.php'),
        ))) !== 0;
    }
}
