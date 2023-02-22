<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Database\Console\Seeds\SeederMakeCommand as LaravelSeederMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;
use Illuminate\Support\Str;

class SeederMakeCommand extends LaravelSeederMakeCommand
{
    use ConsoleGenerator;

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
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        return config('porto.root').'/'.$name.'.php';
    }

    /**
     * @return string
     */
    protected function getNecessaryNamespace(): string
    {
        if($container = $this->option('container')){
            $containerNamespace = $this->getNamespaceFromPath($container);

            return $this->getContainersNamespace().'\\'.$containerNamespace.'\Data';
        }

        return $this->getShipNamespace();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Seeders';
    }
}
