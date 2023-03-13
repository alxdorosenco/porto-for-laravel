<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideTestUi(): array
    {
        return [
            'api' => ['api'],
            'web' => ['web']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithContainer(string $ui)
    {
        $commandStatus = $this->artisan('make:request', [
            'name' => 'Test1Request',
            '--uiType' => $ui,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
