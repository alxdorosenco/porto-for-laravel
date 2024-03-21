<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RuleMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'implicit' => ['implicit']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:rule', [
            'name' => 'TestRule',
        ])
            ->expectsOutputToContain('Rule must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestRule';

        $this->artisan('make:rule', [
            'name' => 'TestRule',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Rule ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Rules/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Rules/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRuleContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Rule';

        $this->artisan('make:rule', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Rules/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'implicit'){
            $this->assertEquals($this->getRuleImplicitContent($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getRuleContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getRuleContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class $name implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \\{$this->portoPathUcFirst()}\Ship\Abstracts\Translations\PotentiallyTranslatedString  ".'$fail'."
     */
    public function validate(string ".'$attribute'.", mixed ".'$value'.", Closure ".'$fail'."): void
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @return string
     */
    private function getRuleImplicitContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class $name implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public ".'$implicit'." = true;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \\{$this->portoPathUcFirst()}\Ship\Abstracts\Translations\PotentiallyTranslatedString  ".'$fail'."
     */
    public function validate(string ".'$attribute'.", mixed ".'$value'.", Closure ".'$fail'."): void
    {
        //
    }
}
";
    }
}
