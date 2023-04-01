<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Foundation\Console\NotificationMakeCommand as LaravelNotificationMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;

class NotificationMakeCommand extends LaravelNotificationMakeCommand
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
            $this->error('Notification must be in the container');

            return false;
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
        return $this->option('markdown')
            ? __DIR__.'/stubs/markdown-notification.stub'
            : __DIR__.'/stubs/notification.stub';
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
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getNecessaryNamespace().'\Notifications';
    }
}
