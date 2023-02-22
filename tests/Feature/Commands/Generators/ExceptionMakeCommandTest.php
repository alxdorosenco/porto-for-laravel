<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ExceptionMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'render' => ['render'],
            'report' => ['report']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:exception', [
            'name' => 'TestException',
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:exception', [
            'name' => 'Test1Exception',
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
        $this->artisan('make:exception', [
            'name' => 'Test2'.(ucfirst($type)).'Exception',
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertSuccessful();
    }
}
