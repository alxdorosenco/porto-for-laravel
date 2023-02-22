<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\MailMakeCommand as LaravelMailMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class MailMakeCommand extends LaravelMailMakeCommand
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
        return __DIR__.$stub;
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param  string  $path
     * @return string
     */
    protected function viewPath($path = ''): string
    {
        $views = config('porto.root').'/Ship/Mails/Templates';

        if($this->option('container')){
            $views = config('porto.root').'/Containers/'.$this->option('container').'/Mails/Templates';
        }

        return $views.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Mails';
    }
}
