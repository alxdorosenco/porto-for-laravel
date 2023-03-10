<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ResourceMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'collection' => ['collection']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:resource', [
            'name' => 'Test1Resource',
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
        $this->artisan('make:resource', [
            'name' => 'Test2'.(ucfirst($type)).'Resource',
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertExitCode(0);
    }
}
