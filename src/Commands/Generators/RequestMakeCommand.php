<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\RequestMakeCommand as LaravelRequestMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Symfony\Component\Console\Input\InputOption;

class RequestMakeCommand extends LaravelRequestMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
        getOptions as protected getOptionsFromTrait;
    }

    /**
     * @var string
     */
    private $uiType;

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
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle(): ?bool
    {
        if (!$this->option('container')) {
            $this->error('Request must be in the container');

            return false;
        }

        if(in_array($this->option('uiType'), ['api', 'web'])){
            $uiType = $this->option('uiType');
        } else {
            $uiType = $this->choice('Please, select type of the user\'s interface', ['api', 'web'], 'web');
        }

        $this->uiType = strtoupper($uiType);

        return $this->handleFromTrait();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\UI\\'.$this->uiType.'\Requests';
    }
}
