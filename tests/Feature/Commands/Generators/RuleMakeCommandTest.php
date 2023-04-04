<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RuleMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:rule', [
            'name' => 'TestRule',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestRule';

        $commandStatus = $this->artisan('make:rule', [
            'name' => 'TestRule',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Rules/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRuleContent($name), file_get_contents($file));
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
