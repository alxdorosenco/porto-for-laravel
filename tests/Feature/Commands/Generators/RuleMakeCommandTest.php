<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RuleMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
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
        ])->assertFailed();
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
        ])->assertSuccessful();

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

use Illuminate\Contracts\Validation\Rule;

class $name implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  ".'$attribute'."
     * @param  mixed  ".'$value'."
     * @return bool
     */
    public function passes(".'$attribute'.", ".'$value'.")
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
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

use Illuminate\Contracts\Validation\ImplicitRule;

class $name implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  ".'$attribute'."
     * @param  mixed  ".'$value'."
     * @return bool
     */
    public function passes(".'$attribute'.", ".'$value'.")
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
";
    }
}
