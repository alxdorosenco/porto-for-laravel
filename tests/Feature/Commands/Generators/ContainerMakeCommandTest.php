<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ContainerMakeCommandTest extends TestCase
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
    public function testConsoleCommandWithWrongName()
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
    public function testConsoleCommand(string $name)
    {
        $commandStatus = $this->artisan('make:container', [
            'name'  => $name === 'default' ? 'Home' : ucfirst($name),
            '--'.$name => true,
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
