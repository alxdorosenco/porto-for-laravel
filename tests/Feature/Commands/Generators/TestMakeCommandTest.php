<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class TestMakeCommandTest extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideTestUi(): array
    {
        return [
            'api' => ['api'],
            'web' => ['web'],
            'cli' => ['cli']
        ];
    }

    /**
     * Test of the console command with unit
     *
     * @return void
     */
    public function testConsoleCommandWithUnit(): void
    {
        $name = 'TestUnit';

        $this->artisan('make:test', [
            'name' => $name,
            '--unit' => true,
            '--container' => $this->containerName
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Tests/Unit/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getUnitTestContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with unit
     *
     * @return void
     */
    public function testConsoleCommandWithPestUnit(): void
    {
        $name = 'TestPestUnit';

        $this->artisan('make:test', [
            'name' => $name,
            '--unit' => true,
            '--pest' => true,
            '--container' => $this->containerName
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Tests/Unit/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getPestUnitTestContent(), file_get_contents($file));
    }

    /**
     * Test of the console command with pest
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithPest(string $ui): void
    {
        $name = 'TestPest';

        $this->artisan('make:test', [
            'name' => $name,
            '--pest' => true,
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', $ui, ['api' => 'api', 'web' => 'web', 'cli' => 'cli'])
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/'.strtoupper($ui).'/Tests/Functional/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getPestTestContent(), file_get_contents($file));
    }

    /**
     * Test of the console command
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithFunctional(string $ui): void
    {
        $name = 'TestFeature';

        $this->artisan('make:test', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', $ui, ['api' => 'api', 'web' => 'web', 'cli' => 'cli'])
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/'.strtoupper($ui).'/Tests/Functional/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTestContent($name, 'Containers\\'.$this->containerName.'\UI\\'.strtoupper($ui).'\Tests\Functional'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getUnitTestContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Tests\Unit;

use PHPUnit\Framework\TestCase;

class $name extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        ".'$this'."->assertTrue(true);
    }
}
";
    }

    /**
     * @param string $name
     * @return string
     */
    private function getTestContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class $name extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        ".'$response'." = ".'$this'."->get('/');

        ".'$response'."->assertStatus(200);
    }
}
";
    }

    /**
     * @return string
     */
    private function getPestTestContent(): string
    {
        return "<?php

test('example', function () {
    ".'$response'." = ".'$this'."->get('/');

    ".'$response'."->assertStatus(200);
});
";
    }

    /**
     * @return string
     */
    private function getPestUnitTestContent(): string
    {
        return "<?php

test('example', function () {
    expect(true)->toBeTrue();
});
";
    }
}
