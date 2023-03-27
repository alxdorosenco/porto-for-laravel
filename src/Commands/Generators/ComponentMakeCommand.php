<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\ComponentMakeCommand as LaravelComponentMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class ComponentMakeCommand extends LaravelComponentMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|int|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Component must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return  __DIR__.$stub;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name): string
    {
        if (!$this->option('inline')) {
            $stub = $this->files->get($this->getStub());
            $container = strtolower(str_replace('/', '@',  $this->option('container')));

            return str_replace(
                ['DummyView', '{{ view }}'],
                'view(\''.$container.'::components.'.$this->getView().'\')',
                $this->replaceNamespace($stub, $name)->replaceClass($stub, $name)
            );
        }

        return parent::buildClass($name);
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param  string  $path
     * @return string
     */
    protected function viewPath($path = ''): string
    {
        $views = config('porto.root').'/Containers/'.$this->option('container').'/UI/WEB/Views';

        return $views.($path ? DIRECTORY_SEPARATOR.$path : $path);
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
        return $this->getNecessaryNamespace().'\Views\Components';
    }
}
