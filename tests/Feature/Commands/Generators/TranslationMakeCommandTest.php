<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class TranslationMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'lang'  => ['lang']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:translation', [
            'name' => 'TestTranslation',
        ])
            ->expectsQuestion('Please, write your language code (for example en, fr, de)', 'en')
            ->assertExitCode(Command::SUCCESS);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $testCommand = $this->artisan('make:translation', [
            'name' => 'Test2'.(ucfirst($type)).'Translation',
            '--'.$type => 'en'
        ]);

        $testCommand->assertExitCode(Command::SUCCESS);
    }
}
