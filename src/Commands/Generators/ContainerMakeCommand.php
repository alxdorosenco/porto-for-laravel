<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Console\Command as LaravelCommand;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\StructureMaker;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:container')]
class ContainerMakeCommand extends LaravelCommand
{
    use FilesAndDirectories, ConsoleGenerator;

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

    /**
     * @return int
     */
    public function handle(): int
    {
        if (!$this->argument('name')) {
            $this->components->error('You can\'t create container without name');
            return static::FAILURE;
        }

        if (preg_match('([^A-Za-z0-9_/\\\\])', $this->argument('name'))) {
            throw new \InvalidArgumentException('Container name contains invalid characters.');
        }

        $this->components->info('Creating ' . $this->argument('name') . ' container');

        $path = config('porto.path');

        $rootPath = config('porto.root');
        $namespace = $this->getNamespaceFromPath($path);

        $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD->value;

        if($this->option('default')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT->value;
        } elseif($this->option('full')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_FULL->value;
        } elseif($this->option('api')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_API->value;
        } elseif($this->option('web')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_WEB->value;
        } elseif($this->option('cli')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_CLI->value;
        }

        $containersBuilder = new ContainersBuilder($rootPath, $namespace);
        $containersBuilder
            ->setContainerName($this->argument('name'))
            ->setContainerType($containerType);

        (new StructureMaker($this, $containersBuilder))->execute();

        $this->output->newLine();

        $this->components->info('Container ['.$this->argument('name').'] has been successfully created');

        return static::SUCCESS;
    }
}
