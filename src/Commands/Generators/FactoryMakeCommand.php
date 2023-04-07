<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Database\Console\Factories\FactoryMakeCommand as LaravelFactoryMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Support\Str;

class FactoryMakeCommand extends LaravelFactoryMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|null
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Factory must be in the container');

            return false;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/factory.stub';
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->getNecessaryNamespace().'\Models';

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $namespaceModel = $this->option('model')
            ? $this->qualifyClass($this->option('model'))
            : trim($this->getShipNamespace(), '\\').'\Models\Model';

        $model = class_basename($namespaceModel);

        return str_replace(
            [
                'NamespacedDummyModel',
                'DummyModel',
            ],
            [
                $namespaceModel,
                $model,
            ],

            $this->buildClassCurrent($name)
        );
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = str_replace(
            ['\\', '/'], '', $this->argument('name')
        );

        return config('porto.root').'/Containers/'.$this->option('container').'/Data/Factories/'.str_replace('\\', '/', $name).'.php';
    }
}
