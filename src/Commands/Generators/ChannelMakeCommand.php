<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\ChannelMakeCommand as LaravelChannelMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ChannelMakeCommand extends LaravelChannelMakeCommand
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
            $this->error('Channel must be in the container');

            return static::FAILURE;
        }

        return $this->handleFromTrait();
    }

    /**
     * Get the model for the default guard's user provider.
     *
     * @return string|null
     */
    protected function userProviderModel(): ?string
    {
        $config = $this->laravel['config'];

        $provider = $config->get('auth.guards.'.$config->get('auth.defaults.guard').'.provider');

        $modelNamespace = $config->get("auth.providers.{$provider}.model");

        if($provider === 'users' && !class_exists($modelNamespace)){
            $modelNamespace = $this->getShipNamespace().'\Models\UserModel';
        }

        return $modelNamespace;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Broadcasting';
    }
}
