<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Models;

use AlxDorosenco\PortoForLaravel\Commands\Traits\Console;
use Illuminate\Database\Console\PruneCommand as LaravelPruneCommand;

class PruneModelCommand extends LaravelPruneCommand
{
    use Console;

    /**
     * Get the path where models are located.
     *
     * @return string[]|string
     */
    protected function getPath()
    {
        if (! empty($path = $this->option('path'))) {
            return collect($path)->map(function ($path) {
                return base_path($path);
            })->all();
        }

        return $this->getNecessaryNamespace().'\Models';
    }
}
