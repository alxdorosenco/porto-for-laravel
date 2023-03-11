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
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $commandStatus = $this->artisan('make:observer', [
            'name' => 'Test1Observer',
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
    public function testConsoleCommandWithTypes(string $type): void
    {
        $typeValue = true;

        if($type === 'model'){
            $typeValue = 'ModelForObserver';
        }

        $commandStatus = $this->artisan('make:observer', [
            'name' => 'Test2'.(ucfirst($type)).'Observer',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
