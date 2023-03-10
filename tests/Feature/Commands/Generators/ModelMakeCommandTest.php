<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ModelMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'all' => ['all'],
            'controller' => ['controller'],
            'factory' => ['factory'],
            'force' => ['force'],
            'migration' => ['migration'],
            'seed' => ['seed'],
            'pivot' => ['pivot'],
            'resource' => ['resource'],
            'api' => ['api']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:model', [
            'name' => 'Test1Model',
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
        $modelName = 'Test2'.(ucfirst($type)).'Model';

       $this->artisan('make:model', [
            'name' => $type === 'factory' ? 'Test2FModel' : $modelName,
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertExitCode(0);
    }
}
