<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Routing\Console\MiddlewareMakeCommand as LaravelMiddlewareMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class MiddlewareMakeCommand extends LaravelMiddlewareMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/middleware.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Middleware';
    }
}
