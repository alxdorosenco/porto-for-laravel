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
    public function testConsoleCommand(): void
    {
        $name = 'TestJob';
        $namespace = 'Ship\Jobs';

        $this->artisan('make:job', [
            'name' => $name
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Ship/Jobs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getJobQueuedContent($name, $namespace), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'Test2Job';
        $namespace = 'Containers\\'.$this->containerName.'\Jobs';

        $this->artisan('make:job', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertSuccessful();

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
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test2'.(ucfirst($type)).'Job';
        $namespace = 'Containers\\'.$this->containerName.'\Jobs';

        $this->artisan('make:job', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertSuccessful();

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

class $name extends Job
{
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

use {$this->portoPathUcFirst()}\Ship\Abstracts\Jobs\JobQueued;

class $name extends JobQueued
{
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
