<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\EventMakeCommand as LaravelEventMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class EventMakeCommand extends LaravelEventMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
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
     * @return bool|null
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Event must be in the container');

            return false;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Events';
    }
}
