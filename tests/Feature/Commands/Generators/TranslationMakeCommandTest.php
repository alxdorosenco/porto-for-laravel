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
        $name = 'TestTranslation';

        $this->artisan('make:translation', [
            'name' => $name
        ])
            ->expectsQuestion('Please, write your language code (for example en, fr, de)', 'en')
            ->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Translations/en/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTranslationContent(), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Translation';

        $this->artisan('make:translation', [
            'name' => $name,
            '--'.$type => 'en'
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Translations/en/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTranslationContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    private function getTranslationContent(): string
    {
        return <<<File
<?php

return [
   // translation arrays
];

File;

    }
}
