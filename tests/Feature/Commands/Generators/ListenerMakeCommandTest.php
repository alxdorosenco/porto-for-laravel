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
    public function testConsoleCommandWithContainer()
    {
        $commandStatus = $this->artisan('make:listener', [
            'name' => 'Test1Listener',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type)
    {
        $typeValue = true;

        if($type === 'event'){
            $typeValue = 'EventListener';
        }

        $commandStatus = $this->artisan('make:listener', [
            'name' => 'Test2'.(ucfirst($type)).'Listener',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
