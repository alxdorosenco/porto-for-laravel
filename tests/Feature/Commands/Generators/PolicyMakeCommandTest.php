<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class PolicyMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'model' => ['model'],
            'guard' => ['guard']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:policy', [
            'name' => 'TestPolicy',
        ])->assertExitCode(Command::FAILURE);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:policy', [
            'name' => 'Test1Policy',
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
            $typeValue = 'ModelForPolicy';
        }

        if($type === 'guard'){
            $typeValue = 'GuardForPolicy';
            $this->expectException(\LogicException::class);
        }

        $this->artisan('make:policy', [
            'name' => 'Test2'.(ucfirst($type)).'Policy',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ])->assertExitCode(Command::SUCCESS);
    }
}
