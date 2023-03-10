<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\ListenerMakeCommand as LaravelListenerMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class ListenerMakeCommand extends LaravelListenerMakeCommand
{
    use ConsoleGenerator {
        handle as protected handleFromTrait;
    }

    /**
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Listener must be in the container');

            return false;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Listeners';
    }
}
