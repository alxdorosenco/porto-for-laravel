<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LogicException;
use Illuminate\Foundation\Console\PolicyMakeCommand as LaravelPolicyMakeCommand;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;

class PolicyMakeCommand extends LaravelPolicyMakeCommand
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
            $this->error('Policy must be in the container');

            return false;
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
     * Replace the User model namespace.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceUserNamespace($stub): string
    {
        $model = $this->userProviderModel();

        if (! $model) {
            return $stub;
        }

        return str_replace(
            $this->rootNamespace().'User',
            $model,
            $stub
        );
    }

    /**
     * Get the model for the guard's user provider.
     *
     * @return string|null
     *
     * @throws \LogicException
     */
    protected function userProviderModel(): ?string
    {
        $config = $this->laravel['config'];

        $provider = $config->get('auth.guards.'.$config->get('auth.defaults.guard').'.provider');

        $modelNamespace = $config->get('auth.providers.'.$provider.'.model');

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
        return $this->getNecessaryNamespace().'\Policies';
    }
}
