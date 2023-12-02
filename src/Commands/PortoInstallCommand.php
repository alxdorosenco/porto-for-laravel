<?php

namespace AlxDorosenco\PortoForLaravel\Commands;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use Illuminate\Console\Command as LaravelCommand;

use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Structure\StructureMaker;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Symfony\Component\Console\Input\InputOption;

class PortoInstallCommand extends LaravelCommand
{
    use FilesAndDirectories;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'porto:install';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'porto:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a whole porto structure pattern';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['container', null, InputOption::VALUE_REQUIRED, 'Create container in current porto structure'],
            ['container-default', 'd', InputOption::VALUE_NONE, 'Create default container in current porto structure'],
            ['container-full', 'f', InputOption::VALUE_NONE, 'Create full container in current porto structure'],
            ['container-api', 'a', InputOption::VALUE_NONE, 'Create api container in current porto structure'],
            ['container-web', 'w', InputOption::VALUE_NONE, 'Create web container in current porto structure'],
            ['container-cli', 'c', InputOption::VALUE_NONE, 'Create web container in current porto structure']
        ];
    }

    public function handle(): int
    {
        $path = null;

        if ($this->confirm('Do you wish to install porto structure in your '.config('porto.path').'/ directory?', true)) {
            $path = config('porto.path');
        }

        if(!$path){
            $path = $this->ask('Please, write your custom directory path');
        }

        if(!$path){
            $this->error('The porto structure can\'t be installed without directory path');

            return false;
        }

        if (preg_match('([^A-Za-z0-9_/\\\\])', $path)) {
            throw new \InvalidArgumentException('Porto path contains invalid characters.');
        }

        $this->info('Installing Porto');

        $rootPath = $this->laravel->basePath().DIRECTORY_SEPARATOR.$path;
        $namespace = $this->getNamespaceFromPath($path);

        $this->setPathInEnvironmentFile($path);

        $shipBuilder = new ShipBuilder($rootPath, $namespace);
        $containersBuilder = new ContainersBuilder($rootPath, $namespace);

        if($this->option('container')){
            $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD;

            if($this->option('container-default')){
                $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT;
            } elseif($this->option('container-full')){
                $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_FULL;
            } elseif($this->option('container-api')){
                $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_API;
            } elseif($this->option('container-web')){
                $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_WEB;
            } elseif($this->option('container-cli')){
                $containerType = ContainerTypes::PORTO_CONTAINER_TYPE_CLI;
            }

            $containersBuilder
                ->setContainerName($this->option('container'))
                ->setContainerType($containerType);
        }

        (new StructureMaker($this, $shipBuilder))->execute();
        (new StructureMaker($this, $containersBuilder))->execute();

        $this->output->newLine();
        $this->info('Porto structure in the ['.$rootPath.'] directory has been successfully installed');

        return 0;
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function setPathInEnvironmentFile(string $path): bool
    {
        if (! $this->writeNewEnvironmentFileWith($path)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function writeNewEnvironmentFileWith(string $path): bool
    {
        $replaced = preg_replace(
            $this->pathReplacementPattern(),
            'PORTO_PATH='.$path,
            $input = file_get_contents($this->laravel->environmentFilePath())
        );

        if(config('porto.path') === $path){
            return false;
        }

        if (!getenv('PORTO_PATH') && ($replaced === $input || $replaced === null)) {
            file_put_contents($this->laravel->environmentFilePath(),"PORTO_PATH=$path", FILE_APPEND | LOCK_EX);

            return true;
        }

        file_put_contents($this->laravel->environmentFilePath(), $replaced);

        return true;
    }

    /**
     * @return string
     */
    protected function pathReplacementPattern(): string
    {
        $escaped = preg_quote('='.config('porto.path'), '/');
        return "/^PORTO_PATH{$escaped}/m";
    }
}
