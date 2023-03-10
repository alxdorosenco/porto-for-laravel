<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ObserverMakeCommandTest extends TestCase
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
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:observer', [
            'name' => 'TestObserver',
        ])->assertExitCode(Command::FAILURE);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:observer', [
            'name' => 'Test1Observer',
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $typeValue = true;

        if($type === 'model'){
            $typeValue = 'ModelForObserver';
        }

        $this->artisan('make:observer', [
            'name' => 'Test2'.(ucfirst($type)).'Observer',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ])->assertExitCode(Command::SUCCESS);
    }
}
