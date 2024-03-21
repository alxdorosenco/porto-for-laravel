<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ListenerMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'event' => ['event'],
            'force' => ['force'],
            'queued' => ['queued'],
            'queued-event' => ['queuedEvent']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:listener', [
            'name' => 'TestListener',
        ])
            ->expectsOutputToContain('Listener must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestListener';

        $this->artisan('make:listener', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Listener ['.$this->portoPath.'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getListenerDuckContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Listener';
        $eventName = 'EventListener';
        $eventNamespace = 'Containers\\'.$this->containerName.'\Events\\'.$eventName;

        $params = [
            'name' => $name,
            '--container' => $this->containerName
        ];

        if($type === 'queuedEvent'){
            $params['--queued'] = true;
            $params['--event'] = $eventName;
        } else {
            $params['--'.$type] = $type === 'event' ? 'EventListener' : true;
        }

        $this->artisan('make:listener', $params)
            ->expectsOutputToContain('Listener ['.$this->portoPath.'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'event'){
            $this->assertEquals($this->getListenerContent($name, $eventNamespace, $eventName), file_get_contents($file));
        } elseif($type === 'queued'){
            $this->assertEquals($this->getListenerQueuedDuckContent($name), file_get_contents($file));
        } elseif($type === 'queuedEvent'){
            $this->assertEquals($this->getListenerQueuedContent($name, $eventNamespace, $eventName), file_get_contents($file));
        } else {
            $this->assertEquals($this->getListenerDuckContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @param string $eventNamespace
     * @param string $eventName
     * @return string
     */
    private function getListenerContent(string $name, string $eventNamespace, string $eventName): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use {$this->portoPathUcFirst()}\\$eventNamespace;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($eventName ".'$event'."): void
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
    private function getListenerDuckContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object ".'$event'."): void
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $eventNamespace
     * @param string $eventName
     * @return string
     */
    private function getListenerQueuedContent(string $name, string $eventNamespace, string $eventName): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use {$this->portoPathUcFirst()}\\$eventNamespace;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($eventName ".'$event'."): void
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
    private function getListenerQueuedDuckContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object ".'$event'."): void
    {
        //
    }
}
";
    }
}
