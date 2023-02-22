<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\ExceptionMakeCommand as LaravelExceptionMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class ExceptionMakeCommand extends LaravelExceptionMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('render')) {
            return $this->option('report')
                ? __DIR__.'/stubs/exception-render-report.stub'
                : __DIR__.'/stubs/exception-render.stub';
        }

        return parent::getStub();
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName): bool
    {
        $className = $this->getNecessaryNamespace().'\Exceptions\\'.$rawName;

        return class_exists($className);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Exceptions';
    }
}
