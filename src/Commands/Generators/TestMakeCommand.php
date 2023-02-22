<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\TestMakeCommand as LaravelTestMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;
use Symfony\Component\Console\Input\InputOption;

class TestMakeCommand extends LaravelTestMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }

    /**
     * @var string
     */
    private string $uiType;

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if ($this->option('container') && !$this->option('unit')) {
            if(in_array($this->option('uiType'), ['api', 'cli', 'web'])){
                $uiType = $this->option('uiType');
            } else {
                $uiType = $this->components->choice('Please, select type of the user\'s interface', ['api', 'web', 'cli'], 'web');
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
    protected function getStub(): string
    {
        if(!$this->option('unit') && !$this->option('pest')){
            return __DIR__.'/stubs/test.stub';
        }

        return parent::getStub();
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
