<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class AuthMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'views' => ['views'],
            'force' => ['force']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:auth', [
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
        $this->artisan('make:auth', [
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertExitCode(0);
    }
}
