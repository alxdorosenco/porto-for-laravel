<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ContainersStructureFilesContent;

class ContainerMakeCommand extends TestCase
{
    use ContainersStructureFilesContent;

    /**
     * @return \string[][]
     */
    protected function provideContainerType(): array
    {
        return [
            'standard' => ['standard'],
            'default' => ['default'],
            'api'  => ['api'],
            'web'  => ['web'],
            'cli'  => ['cli'],
            'full' => ['full']
        ];
    }

    /**
     * @return \string[][]
     */
    protected function provideContainerTypeAndStructure(): array
    {
        return [
            'standard.Actions' => ['standard', 'Actions'],
            'standard.Tasks' => ['standard', 'Tasks'],
            'standard.Models' => ['standard', 'Models'],
            'standard.Loaders.AliasesLoader.php' => ['standard', 'Loaders/AliasesLoader.php'],
            'standard.Loaders.ProvidersLoader.php' => ['standard', 'Loaders/ProvidersLoader.php'],
            'standard.Loaders.MiddlewareLoader.php' => ['standard', 'Loaders/MiddlewareLoader.php'],
            'standard.UI.WEB.Routes' => ['standard', 'UI/WEB/Routes'],
            'standard.UI.WEB.Controllers' => ['standard', 'UI/WEB/Controllers'],
            'standard.UI.WEB.Views' => ['standard', 'UI/WEB/Views'],
            'standard.UI.API.Routes' => ['standard', 'UI/API/Routes'],
            'standard.UI.API.Controllers' => ['standard', 'UI/API/Controllers'],
            'standard.UI.API.Transformers' => ['standard', 'UI/API/Transformers'],
            'standard.UI.CLI.Routes' => ['standard', 'UI/API/Routes'],
            'standard.UI.CLI.Commands' => ['standard', 'UI/CLI/Commands'],
            'default.Actions' => ['default', 'Actions'],
            'default.Tasks' => ['default', 'Tasks'],
            'default.Models' => ['default', 'Models'],
            'default.Loaders.AliasesLoader.php' => ['default', 'Loaders/AliasesLoader.php'],
            'default.Loaders.ProvidersLoader.php' => ['default', 'Loaders/ProvidersLoader.php'],
            'default.Loaders.MiddlewareLoader.php' => ['default', 'Loaders/MiddlewareLoader.php'],
            'default.UI.WEB.Routes.home.php' => ['default', 'UI/WEB/Routes/home.php'],
            'default.UI.WEB.Controllers.HomeController.php' => ['default', 'UI/WEB/Controllers/HomeController.php'],
            'default.UI.WEB.Views.home.blade.php' => ['default', 'UI/WEB/Views/home.blade.php'],
            'default.UI.WEB.Tests.Functional.ExampleTest.php' => ['default', 'UI/WEB/Tests/Functional/ExampleTest.php'],
            'default.UI.API.Routes' => ['default', 'UI/API/Routes'],
            'default.UI.API.Controllers' => ['default', 'UI/API/Controllers'],
            'default.UI.API.Transformers' => ['default', 'UI/API/Transformers'],
            'default.UI.CLI.Routes' => ['default', 'UI/API/Routes'],
            'default.UI.CLI.Commands' => ['default', 'UI/CLI/Commands'],
            'api.Actions' => ['api', 'Actions'],
            'api.Tasks' => ['api', 'Tasks'],
            'api.Models' => ['api', 'Models'],
            'api.Loaders.AliasesLoader.php' => ['api', 'Loaders/AliasesLoader.php'],
            'api.Loaders.ProvidersLoader.php' => ['api', 'Loaders/ProvidersLoader.php'],
            'api.Loaders.MiddlewareLoader.php' => ['api', 'Loaders/MiddlewareLoader.php'],
            'api.UI.API.Routes' => ['api', 'UI/API/Routes'],
            'api.UI.API.Controllers' => ['api', 'UI/API/Controllers'],
            'api.UI.API.Transformers' => ['api', 'UI/API/Transformers'],
            'web.Actions' => ['web', 'Actions'],
            'web.Tasks' => ['web', 'Tasks'],
            'web.Models' => ['web', 'Models'],
            'web.Loaders.AliasesLoader.php' => ['web', 'Loaders/AliasesLoader.php'],
            'web.Loaders.ProvidersLoader.php' => ['web', 'Loaders/ProvidersLoader.php'],
            'web.Loaders.MiddlewareLoader.php' => ['web', 'Loaders/MiddlewareLoader.php'],
            'web.UI.WEB.Routes' => ['web', 'UI/WEB/Routes'],
            'web.UI.WEB.Controllers' => ['web', 'UI/WEB/Controllers'],
            'web.UI.WEB.Transformers' => ['web', 'UI/WEB/Views'],
            'cli.Actions' => ['cli', 'Actions'],
            'cli.Tasks' => ['cli', 'Tasks'],
            'cli.Models' => ['cli', 'Models'],
            'cli.Loaders.AliasesLoader.php' => ['cli', 'Loaders/AliasesLoader.php'],
            'cli.Loaders.ProvidersLoader.php' => ['cli', 'Loaders/ProvidersLoader.php'],
            'cli.Loaders.MiddlewareLoader.php' => ['cli', 'Loaders/MiddlewareLoader.php'],
            'cli.UI.CLI.Routes' => ['web', 'UI/CLI/Routes'],
            'cli.UI.CLI.Controllers' => ['web', 'UI/CLI/Commands'],

            'full.Actions' => ['full', 'Actions'],
            'full.Tasks' => ['full', 'Tasks'],
            'full.Models' => ['full', 'Models'],
            'full.Values' => ['full', 'Values'],
            'full.Events' => ['full', 'Events'],
            'full.Listeners' => ['full', 'Listeners'],
            'full.Policies' => ['full', 'Policies'],
            'full.Exceptions' => ['full', 'Exceptions'],
            'full.Contracts' => ['full', 'Contracts'],
            'full.Traits' => ['full', 'Traits'],
            'full.Jobs' => ['full', 'Jobs'],
            'full.Notifications' => ['full', 'Notifications'],
            'full.Providers' => ['full', 'Providers'],
            'full.Configs' => ['full', 'Configs'],
            'full.Loaders.AliasesLoader.php' => ['full', 'Loaders/AliasesLoader.php'],
            'full.Loaders.ProvidersLoader.php' => ['full', 'Loaders/ProvidersLoader.php'],
            'full.Loaders.MiddlewareLoader.php' => ['full', 'Loaders/MiddlewareLoader.php'],
            'full.UI.WEB.Routes' => ['full', 'UI/WEB/Routes'],
            'full.UI.WEB.Controllers' => ['full', 'UI/WEB/Controllers'],
            'full.UI.WEB.Views' => ['full', 'UI/WEB/Views'],
            'full.UI.API.Routes' => ['full', 'UI/API/Routes'],
            'full.UI.API.Controllers' => ['full', 'UI/API/Controllers'],
            'full.UI.API.Transformers' => ['full', 'UI/API/Transformers'],
            'full.UI.CLI.Routes' => ['full', 'UI/API/Routes'],
            'full.UI.CLI.Commands' => ['full', 'UI/CLI/Commands'],
        ];
    }

    /**
     * Test of the console command without name
     *
     * @return void
     */
    public function testConsoleCommandWithoutName(): void
    {
        $this->artisan('make:container')
            ->expectsOutputToContain('You can\'t create container without name')
            ->assertFailed();
    }

    /**
     * Test of the console command without name
     *
     * @return void
     */
    public function testConsoleCommandWithWrongName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Container name contains invalid characters.');

        $this->artisan('make:container', [
            'name' => 'Wrong\\%@@#*Name'
        ]);
    }

    /**
     * Test of the console command
     *
     * @dataProvider provideContainerType
     * @return void
     */
    public function testConsoleCommand(string $type): void
    {
        $this->artisan('make:container', [
            'name'  => ucfirst($type),
            '--'.$type => true,
        ])  ->expectsOutputToContain('Creating ' .ucfirst($type). ' container')
            ->expectsOutput("\n")
            ->expectsOutputToContain('Container ['.ucfirst($type).'] has been successfully created')
            ->assertSuccessful();
    }

    /**
     * @param string $type
     * @param string $param
     *
     * @dataProvider provideContainerTypeAndStructure
     * @return void
     */
    public function testExistenceOfTheCreatedContainerFilesAndDirectories(string $type, string $param): void
    {
        if(str_ends_with($param, '.php')){
            $file = base_path($this->portoPath).'/'.$param;

            $this->assertFileExists($file);

            $content = file_get_contents($file);

            $methodName = 'content'.str_replace(['/', '.php'], ['', ''], $param);
            $this->assertEquals($this->$methodName(), $content);
        } else {
            $this->assertDirectoryExists(base_path($this->portoPath).'/'.$param);
        }
    }
}
