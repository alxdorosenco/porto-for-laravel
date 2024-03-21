<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ScopeMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'force' => ['force']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:scope', [
            'name' => 'TestScope',
        ])
            ->expectsOutputToContain('Scope must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestScope';

        $this->artisan('make:scope', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Scope ['.$this->portoPath.'/Containers/'.$this->containerName.'/Models/Scopes/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/Scopes/'.$name.'.php';

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
        $name = 'Test'.(ucfirst($type)).'Scope';

        $this->artisan('make:scope', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain('Scope ['.$this->portoPath.'/Containers/'.$this->containerName.'/Models/Scopes/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/Scopes/'.$name.'.php';

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

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\Scopes;

use {$this->portoPathUcFirst()}\Ship\Models\Builder;
use {$this->portoPathUcFirst()}\Ship\Models\Model;
use {$this->portoPathUcFirst()}\Ship\Models\Scope;

class $name implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Models\Builder  ".'$builder'."
     * @param  \\{$this->portoPathUcFirst()}\Ship\Models\Model  ".'$model'."
     * @return void
     */
    public function apply(Builder ".'$builder'.", Model ".'$model'.")
    {
        //
    }
}
";
    }
}
