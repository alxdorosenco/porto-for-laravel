<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ListenerMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'event' => ['event'],
            'queued' => ['queued']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:listener', [
            'name' => 'Test1Listener',
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
        $typeValue = true;

        if($type === 'event'){
            $typeValue = 'EventListener';
        }

        $this->artisan('make:listener', [
            'name' => 'Test2'.(ucfirst($type)).'Listener',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ])->assertExitCode(0);
    }
}
