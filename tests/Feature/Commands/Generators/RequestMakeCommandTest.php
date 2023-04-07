<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideTestUi(): array
    {
        return [
            'api' => ['api'],
            'web' => ['web']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithContainer(string $ui)
    {
        $name = 'TestRequest';

        $commandStatus = $this->artisan('make:request', [
            'name' => $name,
            '--uiType' => $ui,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Requests/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRequestContent($name, 'Containers\\'.$this->containerName.'\UI\API\Requests'), file_get_contents($file));
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
     * @return array
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
