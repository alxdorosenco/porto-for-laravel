<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\JobMakeCommand as LaravelJobMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class JobMakeCommand extends LaravelJobMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('sync')
            ? __DIR__.'/stubs/job.stub'
            : __DIR__.'/stubs/job.queued.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Jobs';
    }
}
