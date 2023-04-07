<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\TestMakeCommand as LaravelTestMakeCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Symfony\Component\Console\Input\InputOption;

class TestMakeCommand extends LaravelTestMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:test
        {name : The name of the class}
        {--unit : Create a unit test}
        {--container= : Name of the container}
        {--uiType= : Type of the user\'s interface}';

    /**
     * @var string
     */
    private $uiType;

    /**
     * @return bool|null
     */
    public function handle()
    {
        if ($this->option('container') && !$this->option('unit')) {
            if(in_array($this->option('uiType'), ['api', 'cli', 'web'])){
                $uiType = $this->option('uiType');
            } else {
                $uiType = $this->choice('Please, select type of the user\'s interface', ['api', 'web', 'cli'], 'web');
            }

            $this->uiType = strtoupper($uiType);
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
        if ($this->option('unit')) {
            return __DIR__.'/stubs/unit-test.stub';
        }

        return __DIR__.'/stubs/test.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = $this->getOptionsFromTrait();

        $options[] = ['uiType', null, InputOption::VALUE_OPTIONAL, 'Type of the container\'s user interface'];

        return $options;
    }

    /**
     * @return string
     */
    protected function getNecessaryNamespace(): string
    {
        if($container = $this->option('container')){
            $containerNamespace = $this->getNamespaceFromPath($container);

            if(!$this->option('unit')){
                $containerNamespace .= '\UI\\'.$this->uiType;
            }

            return $this->getContainersNamespace().'\\'.$containerNamespace;
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
        if ($this->option('unit')) {
            return $this->getNecessaryNamespace().'\Tests\Unit';
        }

        return $this->getNecessaryNamespace().'\Tests\Functional';
    }
}
