<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
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
        $this->artisan('make:request', [
            'name' => 'TestRequest',
        ])
            ->expectsOutputToContain('Request must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestRequest';

        $this->artisan('make:request', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', 'api', ['api' => 'api', 'web' => 'web'])
            ->expectsOutputToContain('Request ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/API/Requests/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Requests/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRequestContent($name, 'Containers\\'.$this->containerName.'\UI\API\Requests'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Request';

        $this->artisan('make:request', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsChoice('Please, select type of the user\'s interface', 'web', ['api' => 'api', 'web' => 'web'])
            ->expectsOutputToContain('Request ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/WEB/Requests/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Requests/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRequestContent($name, 'Containers\\'.$this->containerName.'\UI\WEB\Requests'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getRequestContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Requests\FormRequest;

class $name extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

Class;

    }
}
