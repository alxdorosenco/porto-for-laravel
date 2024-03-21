<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ResourceMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'collection' => ['collection']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:resource', [
            'name' => 'TestResource',
        ])
            ->expectsOutputToContain('Resource must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestResource';

        $this->artisan('make:resource', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Resource ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/API/Transformers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Transformers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getResourceContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Resource';

        $typeName = $type === 'collection' ? 'Resource collection' : 'Resource';

        $this->artisan('make:resource', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain($typeName.' ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/API/Transformers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Transformers/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'collection'){
            $this->assertEquals($this->getResourceCollectionContent($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getResourceContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getResourceContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Transformers;

use {$this->portoPathUcFirst()}\Ship\Resources\JsonResource;

class $name extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(".'$request'.")
    {
        return parent::toArray(".'$request'.");
    }
}
";

    }

    /**
     * @param string $name
     * @return string
     */
    private function getResourceCollectionContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Transformers;

use {$this->portoPathUcFirst()}\Ship\Resources\ResourceCollection;

class $name extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(".'$request'.")
    {
        return parent::toArray(".'$request'.");
    }
}
";

    }
}
