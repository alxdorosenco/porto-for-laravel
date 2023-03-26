<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\PolicyContent;

class PolicyMakeCommandTest extends TestCase
{
    use PolicyContent;

    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'model' => ['model'],
            'guard' => ['guard']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:policy', [
            'name' => 'TestPolicy',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestPolicy';

        $this->artisan('make:policy', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Policies/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getPolicyContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Policy';
        $modelName = 'ModelForPolicy';
        $guardName = 'GuardForPolicy';

        $params = [
            'name' => $name,
            '--container' => $this->containerName,
        ];

        if($type === 'model'){
            $params['--'.$type] = $modelName;
        }

        if($type === 'guard'){
            $params['--'.$type] = $guardName;
            $this->expectException(\LogicException::class);
        }

        $this->artisan('make:policy', $params)
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Policies/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'model'){
            $this->assertEquals($this->getPolicyModelContent($name, $modelName), file_get_contents($file));
        } else {
            $this->assertEquals($this->getPolicyContent($name), file_get_contents($file));
        }
    }
}
