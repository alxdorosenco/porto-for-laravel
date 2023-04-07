<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class JobMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'sync' => ['sync']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $name = 'TestJob';
        $namespace = 'Ship\Jobs';

        $commandStatus = $this->artisan('make:job', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Jobs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getJobQueuedContent($name, $namespace), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $name = 'Test2Job';
        $namespace = 'Containers\\'.$this->containerName.'\Jobs';

        $commandStatus = $this->artisan('make:job', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Jobs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getJobQueuedContent($name, $namespace), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type)
    {
        $name = 'Test2'.(ucfirst($type)).'Job';
        $namespace = 'Containers\\'.$this->containerName.'\Jobs';

        $commandStatus = $this->artisan('make:job', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Jobs/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'sync'){
            $this->assertEquals($this->getJobContent($name, $namespace), file_get_contents($file));
        } else {
            $this->assertEquals($this->getJobQueuedContent($name, $namespace), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getJobContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Jobs\Job;
use Illuminate\Foundation\Bus\Dispatchable;

class $name extends Job
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}

Class;

    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getJobQueuedContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class $name implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}

Class;

    }
}
