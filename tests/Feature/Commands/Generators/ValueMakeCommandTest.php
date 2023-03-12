<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ValueMakeCommandTest extends TestCase
{
    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $commandStatus = $this->artisan('make:value', [
            'name' => 'Test1Value',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
