<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class AuthMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'views' => ['views'],
            'force' => ['force']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:auth', [
            '--container' => $this->containerName
        ])->assertExitCode(0);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $command = $this->artisan('make:auth', [
            '--container' => $this->containerName,
            '--'.$type => true
        ]);

        if($type === 'views'){
            $command
                ->expectsQuestion("The [auth/login.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [auth/register.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [auth/verify.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [auth/passwords/email.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [auth/passwords/reset.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [layouts/app.blade.php] view already exists. Do you want to replace it?", true)
                ->expectsQuestion("The [home.blade.php] view already exists. Do you want to replace it?", true);
        }

        $command->assertExitCode(0);
    }
}
