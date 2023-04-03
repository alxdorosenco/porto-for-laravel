<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Auth\Console\AuthMakeCommand as LaravelAuthMakeCommand;

class AuthMakeCommand extends LaravelAuthMakeCommand
{
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

            file_put_contents(
                config('porto.root').'/Containers/'.$this->option('container').'/UI/WEB/Routes/web.php',
                file_get_contents(__DIR__.'/make/routes.stub'),
                FILE_APPEND
            );
        }

        $this->info('Authentication scaffolding generated successfully.');
    }
}
