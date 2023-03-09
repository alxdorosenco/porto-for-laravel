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

        if($this->option('container')){
            return config('porto.root').'/Containers/'.$this->option('container').'/Data/Seeders/'.$name.'.php';
        }

        return config('porto.root').'/Ship/Seeders/'.$name.'.php';
    }
}
