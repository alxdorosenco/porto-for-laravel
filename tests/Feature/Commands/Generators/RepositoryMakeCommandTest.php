<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class RepositoryMakeCommandTest extends TestCase
{
    use FilesAndDirectories;

    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'model' => ['model']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:repository', [
            'name' => 'TestRepository',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestRepository';

        $this->artisan('make:repository', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Repositories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRepositoryContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Repository';
        $modelName = 'TestModelForRepository';
        $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);

        $this->artisan('make:repository', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $modelName
        ])
            ->expectsQuestion('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Repositories/'.$name.'.php';
        $modelFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';

        $this->assertFileExists($file);
        $this->assertFileExists($modelFile);
        $this->assertEquals($this->getRepositoryModelContent($name, $modelName), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getRepositoryContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Repositories;

class $name
{
    // repository class
}

Class;

    }

    /**
     * @param string $name
     * @param string $model
     * @return string
     */
    private function getRepositoryModelContent(string $name, string $model): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Repositories;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;

class $name
{
    private ".'$model'.";

    /**
     * Model in the constructor property promotion
     *
     * @return void
     */
    public function __construct($model ".'$model'.")
    {
        ".'$this->model'." = ".'$model'.";
    }
}
";
    }
}
