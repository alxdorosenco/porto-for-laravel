<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Filesystem\Filesystem;
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
     * @param string $path
     * @return string
     */
    protected function viewPath(string $path = ''): string
    {
        $views = config('porto.root').'/Ship/Mails/Templates';

        if($this->option('container')){
            $views = config('porto.root').'/Containers/'.$this->option('container').'/Mails/Templates';
        }

        return $views.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Write the Markdown template for the mailable.
     *
     * @return void
     */
    protected function writeMarkdownTemplate()
    {
        $path = $this->viewPath(str_replace('.', '/', $this->option('markdown')).'.blade.php');

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, file_get_contents(dirname((new \ReflectionClass(new parent(new Filesystem())))->getFileName()).'/stubs/markdown.stub'));
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
