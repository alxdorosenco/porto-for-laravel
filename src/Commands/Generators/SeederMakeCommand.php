<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Database\Console\Seeds\SeederMakeCommand as LaravelSeederMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Support\Str;

class SeederMakeCommand extends LaravelSeederMakeCommand
{
    use ConsoleGenerator;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
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

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace'],
            ['{{ namespace }}', '{{ rootNamespace }}'],
            ['{{namespace}}', '{{rootNamespace}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getCurrentNamespace(), $this->rootNamespace()],
                $stub
            );
        }

        return $this;
    }

    /**
     * @return string
     */
    private function getCurrentNamespace(): string
    {
        return $this->getNecessaryNamespace().'\\'.($this->option('container') ? 'Data\Seeders' : 'Seeders');
    }
}
