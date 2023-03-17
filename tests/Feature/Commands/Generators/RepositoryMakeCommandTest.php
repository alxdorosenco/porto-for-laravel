<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class RepositoryMakeCommandTest extends TestCase
{
    use FilesAndDirectories;

    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'model' => ['model']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:repository', [
            'name' => 'TestRepository',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:repository', [
            'name' => 'Test1Repository',
            '--container' => $this->containerName
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $testCommand = $this->artisan('make:repository', [
            'name' => 'Test2'.(ucfirst($type)).'Repository',
            '--container' => $this->containerName,
            '--'.$type => 'TestModelForRepository'
        ]);

        if($type === 'model'){
            $namespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestModelForRepository');
            $testCommand->expectsQuestion('A '.$namespace.' model does not exist. Do you want to generate it?', 'yes');
        }

        $testCommand->assertSuccessful();
    }
}
