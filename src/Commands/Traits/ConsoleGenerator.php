<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;

trait ConsoleGenerator
{
    use Console;

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['container', null, InputOption::VALUE_REQUIRED, 'Create the class in the named container directory'];

        return $options;
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        $searches = [
            ['{{ namespaceRequest }}', '{{ namespaceResponse }}', '{{ namespaceRedirectResponse }}'],
            ['{{namespaceRequest}}', '{{namespaceResponse}}', '{{namespaceRedirectResponse}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getNamespaceRequest(), $this->getNamespaceResponse(), $this->getNamespaceRedirectResponse()],
                $stub
            );
        }

        return $stub;
    }

    /**
     * @return bool|void|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!$this->findExistingDirectory(config('porto.root').'/Containers/'.$this->option('container'))) {
            $this->components->error('Container "'.$this->option('container').'" does not exist.');

            return Command::FAILURE;
        }

        return parent::handle();
    }
}
