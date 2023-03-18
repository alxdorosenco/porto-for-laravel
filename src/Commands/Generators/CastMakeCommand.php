<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\CastMakeCommand as LaravelCastMakeCommand;
use Illuminate\Database\Eloquent\Model;

class CastMakeCommand extends LaravelCastMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|int|null
     * @throws FileNotFoundException
     */
    public function handle(): bool|int|null
    {
        if (!$this->option('container')) {
            $this->components->error('Cast must be in the container');

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
        return __DIR__.$stub;
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
            ['DummyBaseModelNamespace'],
            ['{{ baseModelNamespace }}'],
            ['{{baseModelNamespace}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getBaseModelNamespace()],
                $stub
            );
        }

        return parent::replaceNamespace($stub, $name);
    }

    protected function getBaseModelNamespace(): string
    {
        $filePath = config('porto.root').'/Ship/Models/Model.php';
        $namespace = $this->findExistingFile($filePath) ? $this->getShipNamespace().'\Models\Model' : Model::class;

        return '\\'.$namespace;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Casts';
    }
}
