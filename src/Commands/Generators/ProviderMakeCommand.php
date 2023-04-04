<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\ProviderMakeCommand as LaravelProviderMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class ProviderMakeCommand extends LaravelProviderMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/provider.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Providers';
    }
}
