<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\RuleMakeCommand as LaravelRuleMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class RuleMakeCommand extends LaravelRuleMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->components->error('Rule must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('invokable')) {
            return __DIR__.'/stubs/rule.invokable.stub';
        }

        if ($this->option('implicit') && $this->option('invokable')) {
            return __DIR__.'/stubs/rule.invokable.implicit.stub';
        }

        return parent::getStub();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Data\Rules';
    }
}
