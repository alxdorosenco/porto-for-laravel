<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;
use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\StructureMaker;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ContainerMakeCommand extends GeneratorCommand
{
    use ConsoleGenerator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:container';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:container';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new container in the Porto';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The container name of the porto', null],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['default', 'd', InputOption::VALUE_NONE, 'Create default container in current porto structure'],
            ['full', 'f', InputOption::VALUE_NONE, 'Create full container in current porto structure'],
            ['api', 'a', InputOption::VALUE_NONE, 'Create api container in current porto structure'],
            ['web', 'w', InputOption::VALUE_NONE, 'Create web container in current porto structure'],
            ['cli', 'c', InputOption::VALUE_NONE, 'Create web container in current porto structure']
        ];
    }

    public function getStub(){}

    /**
     * @return int
     */
    public function handle(): int
    {
        if (!$this->argument('name')) {
            $this->error('You can\'t create container without name');
            return false;
        }

        if (preg_match('([^A-Za-z0-9_/\\\\])', $this->argument('name'))) {
            throw new \InvalidArgumentException('Container name contains invalid characters.');
        }

        $this->info('Creating ' . $this->argument('name') . ' container');

        $path = config('porto.path');

        $rootPath = config('porto.root');
        $namespace = $this->getNamespaceFromPath($path);

        $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD;

        if($this->option('default')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT;
        } elseif($this->option('full')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_FULL;
        } elseif($this->option('api')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_API;
        } elseif($this->option('web')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_WEB;
        } elseif($this->option('cli')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_CLI;
        }

        $containersBuilder = new ContainersBuilder($rootPath, $namespace);
        $containersBuilder
            ->setContainerName($this->argument('name'))
            ->setContainerType($containerType);

        (new StructureMaker($this, $containersBuilder))->execute();

        $this->output->newLine();

        $this->info('Container ['.$this->argument('name').'] has been successfully created');

        return 0;
    }
}
