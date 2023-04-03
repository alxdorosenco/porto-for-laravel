<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Auth\Console\AuthMakeCommand as LaravelAuthMakeCommand;

class AuthMakeCommand extends LaravelAuthMakeCommand
{
    use FilesAndDirectories;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:auth
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}
                    {--container= : Name of the container}';

    /**
     * Execute the console command.
     *
     * @return false|void
     */
    public function handle()
    {
        if (!$this->option('container')) {
            $this->error('Auth must be in the container');

            return false;
        }

        $this->createDirectories();

        $this->exportViews();

        if (! $this->option('views')) {
            file_put_contents(
                config('porto.root').'/Containers/'.$this->option('container').'/UI/WEB/Controllers/HomeController.php',
                $this->compileControllerStub()
            );

            $routePath = config('porto.root').'/Containers/'.$this->option('container').'/UI/WEB/Routes/home.php';

            if($this->findExistingFile($routePath)){
                file_put_contents(
                    $routePath,
                    file_get_contents(dirname((new \ReflectionClass(new parent()))->getFileName()).'/stubs/make/routes.stub'),
                    FILE_APPEND
                );
            }
        }

        $this->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Get full view path relative to the app's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('porto.root').'/Containers/'.$this->option('container').'/UI/WEB/Views',
            $path
        ]);
    }
}
