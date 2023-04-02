<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Database\Console\Factories\FactoryMakeCommand as LaravelFactoryMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FactoryMakeCommand extends LaravelFactoryMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle(): ?bool
    {
        if (!$this->option('container')) {
            $this->error('Factory must be in the container');

            return false;
        }

        return $this->handleFromTrait();
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
            : trim($this->rootNamespace(), '\\').'\\Model';

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
            parent::buildClass($name)
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

    /**
     * Qualify the given model class base name.
     *
     * @param  string  $model
     * @return string
     */
    protected function qualifyModel(string $model): string
    {
        $model = ltrim($model, '\\/');

        return config('porto.root').'/Containers/'.$this->option('container').'/Data/Factories/'.$nameFactory.'.php';
    }
}
