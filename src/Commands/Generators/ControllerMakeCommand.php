<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Routing\Console\ControllerMakeCommand as LaravelControllerMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends LaravelControllerMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = $this->getOptionsFromTrait();

        $options[] = ['api', null, InputOption::VALUE_NONE, 'Create the class in the container\'s UI/API directory'];

        return $options;
    }

    /**
     * @return bool|null
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Controller must be in the container');

            return false;
        }

        return $this->handleFromTrait();
    }

    protected function getStub()
    {
        if ($this->option('parent')) {
            return __DIR__.'/stubs/controller.nested.stub';
        } elseif ($this->option('model')) {
            return __DIR__.'/stubs/controller.model.stub';
        } elseif ($this->option('resource')) {
            return __DIR__.'/stubs/controller.stub';
        }

        return __DIR__.'/stubs/controller.plain.stub';
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if (! class_exists($parentModelClass) &&
            $this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
            $this->call('make:model', [
                'name' => $parentModelClass,
                '--container' => $this->option('container')
            ]);
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     *
     * @param  array  $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass, '--container' => $this->option('container')]);
            }
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = $this->option('api') ? 'UI\API\Controllers' : 'UI\WEB\Controllers';
        return $this->getNecessaryNamespace().'\\'.$namespace;
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new \InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
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

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->getNecessaryNamespace();

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        return $rootNamespace.'\\Models\\'.$model;
    }
}
