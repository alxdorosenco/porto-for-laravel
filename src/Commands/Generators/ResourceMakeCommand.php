<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\ResourceMakeCommand as LaravelResourceMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class ResourceMakeCommand extends LaravelResourceMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->components->error('Resource must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return  __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\UI\API\Transformers';
    }
}
