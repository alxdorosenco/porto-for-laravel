<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\MailMakeCommand as LaravelMailMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class MailMakeCommand extends LaravelMailMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('markdown')
            ? __DIR__.'/stubs/markdown-mail.stub'
            : __DIR__.'/stubs/mail.stub';
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
