<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Models;

use AlxDorosenco\PortoForLaravel\Traits\Console;
use Illuminate\Database\Console\ShowModelCommand as LaravelShowModelCommand;

class ShowModelCommand extends LaravelShowModelCommand
{
    use Console;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'model:show {model : The model to show}
                {--database= : The database connection to use}
                {--json : Output the model as JSON}
                {--container : container directory}';

    /**
     * Qualify the given model class base name.
     *
     * @param  string  $model
     * @return string
     *
     * @see \Illuminate\Console\GeneratorCommand
     */
    protected function qualifyModel(string $model): string
    {
        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->getNecessaryNamespace().'\Models';

        return $rootNamespace.'\\'.$model;
    }
}
