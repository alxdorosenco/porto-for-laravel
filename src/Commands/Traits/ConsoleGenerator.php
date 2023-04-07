<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Traits;

use Symfony\Component\Console\Input\InputOption;

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
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function buildClassCurrent($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @return bool|void|null
     */
    public function handle()
    {
        if (!$this->findExistingDirectory(config('porto.root').'/Containers/'.$this->option('container'))) {
            $this->error('Container "'.$this->option('container').'" does not exist.');

            return false;
        }

        return parent::handle();
    }
}
