<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ContainerMakeCommand extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideContainerName(): array
    {
        return [
            'default' => ['default'],
            'api'  => ['api'],
            'web'  => ['web'],
            'cli'  => ['cli'],
            'full' => ['full']
        ];
    }

    /**
     * Test of the console command without name
     *
     * @return void
     */
    public function testConsoleCommandWithoutName(): void
    {
        $this->artisan('make:container')->assertFailed();
    }

    /**
     * Test of the console command without name
     *
     * @return void
     */
    public function testConsoleCommandWithWrongName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->artisan('make:container', [
            'name' => 'Wrong\\%@@#*Name'
        ]);
    }

    /**
     * Test of the console command
     *
     * @dataProvider provideContainerName
     * @return void
     */
    public function testConsoleCommand(string $name): void
    {
        $this->artisan('make:container', [
            'name'  => ucfirst($name),
            '--'.$name => true,
        ])->assertSuccessful();
    }
}
