<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Traits;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\ConsoleGenerator;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class ConsoleGeneratorTraitTest extends TestCase
{
    /**
     * @var __anonymous@406
     */
    private $trait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class(new Filesystem()) extends GeneratorCommand {
            use ConsoleGenerator {
                getOptions as public;
                buildClass as public;
            }

            /**
             * @var string
             */
            private $stub;

            /**
             * @param string $stub
             * @return $this
             */
            public function setStub(string $stub)
            {
                $this->stub = $stub;

                return $this;
            }

            protected function getStub(): string
            {
                return $this->stub;
            }

            /**
             * Get the model for the default guard's user provider.
             *
             * @return string|null
             */
            protected function userProviderModel(): ?string
            {
                return 'UserModel';
            }
        };
    }

    /**
     * @return array[]
     */
    public function provideConsoleGeneratorStubs(): array
    {
        return [
            'cast.inbound.stub' => ['cast.inbound.stub'],
            'cast.stub' => ['cast.stub'],
            'console.stub' => ['console.stub'],
            'controller.api.stub' => ['controller.api.stub'],
            'controller.invokable.stub' => ['controller.invokable.stub'],
            'controller.model.stub' => ['controller.model.stub'],
            'controller.nested.api.stub' => ['controller.nested.api.stub'],
            'controller.nested.singleton.api.stub' => ['controller.nested.singleton.api.stub'],
            'controller.nested.singleton.stub' => ['controller.nested.singleton.stub'],
            'controller.nested.stub' => ['controller.nested.stub'],
            'controller.plain.stub' => ['controller.plain.stub'],
            'controller.singleton.api.stub' => ['controller.singleton.api.stub'],
            'controller.singleton.stub' => ['controller.singleton.stub'],
            'controller.stub' => ['controller.stub'],
            'event.stub' => ['event.stub'],
            'exception-render.stub' => ['exception-render.stub'],
            'exception-render-report.stub' => ['exception-render-report.stub'],
            'job.queued.stub' => ['job.queued.stub'],
            'job.stub' => ['job.stub'],
            'mail.stub' => ['mail.stub'],
            'markdown-mail.stub' => ['markdown-mail.stub'],
            'markdown-notification.stub' => ['markdown-notification.stub'],
            'middleware.stub' => ['middleware.stub'],
            'model.morph-pivot.stub' => ['model.morph-pivot.stub'],
            'model.pivot.stub' => ['model.pivot.stub'],
            'model.stub' => ['model.stub'],
            'notification.stub' => ['notification.stub'],
            'policy.plain.stub' => ['policy.plain.stub'],
            'policy.stub' => ['policy.stub'],
            'request.stub' => ['request.stub'],
            'resource.stub' => ['resource.stub'],
            'resource-collection.stub' => ['resource-collection.stub'],
            'rule.invokable.implicit.stub' => ['rule.invokable.implicit.stub'],
            'rule.invokable.stub' => ['rule.invokable.stub'],
            'seeder.stub' => ['seeder.stub'],
            'test.stub' => ['test.stub'],
            'view-component.stub' => ['view-component.stub']
        ];
    }

    /***
     * @return void
     */
    public function testGetOptionsMethod(): void
    {
        $this->assertIsArray($this->trait->getOptions());
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    public function testBuildClassMethodWithWrongStubPath(): void
    {
        $this->trait->setStub('WrongStubPath');
        $this->expectException(FileNotFoundException::class);

        $this->trait->buildClass('ClassName');
    }

    /**
     * @param string $stub
     * @return void
     * @dataProvider provideConsoleGeneratorStubs
     * @throws FileNotFoundException
     */
    public function testBuildClassMethod(string $stub): void
    {
        $this->trait->setStub(__DIR__.'/../../../src/Commands/Generators/stubs/'.$stub);

        $this->assertIsString($this->trait->buildClass('ClassName'));
    }
}
