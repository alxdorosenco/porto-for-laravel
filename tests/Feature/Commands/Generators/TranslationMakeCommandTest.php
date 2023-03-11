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
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $commandStatus = $this->artisan('make:translation', [
            'name' => 'Test2'.(ucfirst($type)).'Translation',
            '--'.$type => 'en'
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
