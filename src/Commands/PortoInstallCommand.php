<?php

namespace AlxDorosenco\PortoForLaravel\Commands;

use Illuminate\Console\Command as LaravelCommand;

use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Structure\StructureMaker;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'porto:install')]
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
            ['container-full', 'cf', InputOption::VALUE_NONE, 'Create full container in current porto structure'],
        ];
    }

    public function handle(): int
    {
        $path = null;

        if ($this->components->confirm('Do you wish to install porto structure in your '.config('porto.path').'/ directory?', true)) {
            $path = config('porto.path');
        }

        if(!$path){
            $path = $this->components->ask('Please, write your custom directory path');
        }

        if(!$path){
            $this->components->error('The porto structure can\'t be installed without directory path');

            return static::FAILURE;
        }

        if (preg_match('([^A-Za-z0-9_/\\\\])', $path)) {
            throw new \InvalidArgumentException('Porto path contains invalid characters.');
        }

        $this->components->info('Installing Porto');

        $rootPath = $this->laravel->basePath().DIRECTORY_SEPARATOR.$path;
        $namespace = $this->getNamespaceFromPath($path);

        $this->setPathInEnvironmentFile($path);

        $shipBuilder = new ShipBuilder($rootPath, $namespace);
        $containersBuilder = new ContainersBuilder($rootPath, $namespace);

        (new StructureMaker($this, $shipBuilder))->execute();
        (new StructureMaker($this, $containersBuilder))->execute();

        $this->output->newLine();

        $this->components->info('Porto structure ['.$rootPath.'] installed successfully');

        if($this->option('container')){
            $containerCommandParams = [
                'name'      => $this->option('container'),
                '--full'    => $this->option('container-full')
            ];

            $this->call('make:container', $containerCommandParams);
        }

        return static::SUCCESS;
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
