<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class RepositoryMakeCommandTest extends TestCase
{
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
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:repository', [
            'name' => 'Test1Repository',
            '--container' => $this->containerName
        ])->assertExitCode(0);
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
            $namespace = ucfirst(config('porto.path')).'\Containers\\'.$this->containerName.'\Models\TestModelForRepository';
            $testCommand->expectsQuestion('A '.$namespace.' model does not exist. Do you want to generate it?', 'yes');
        }

        $testCommand->assertExitCode(0);
    }
}
