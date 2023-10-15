<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Structure\Builder\Stubs;

class StubsTraitTest extends TestCase
{
    /**
     * @var __anonymous@384
     */
    private $trait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use Stubs {
                getStub as public;
                setStubVariable as public;
                getStubContents as public;
            }
        };
    }

    /**
     * @return array
     */
    public function provideStubsFilename(): array
    {
        return [
            'abstract-mail.class.stub' => ['abstract-mail.class.stub'],
            'abstract-controller.class.stub' => ['abstract-controller.class.stub'],
            'abstract-event.class.stub' => ['abstract-event.class.stub'],
            'abstract-extended.class.stub' => ['abstract-extended.class.stub'],
            'abstract-job.class.stub' => ['abstract-job.class.stub'],
            'abstract-job-queued.class.stub' => ['abstract-job-queued.class.stub'],
            'abstract-test-case.class.stub' => ['abstract-test-case.class.stub'],
            'abstract-user-model.class.stub' => ['abstract-user-model.class.stub'],
            'exception-handler.class.stub' => ['exception-handler.class.stub'],
            'home.blade.stub' => ['home.blade.stub'],
            'home-controller.class.stub' => ['home-controller.class.stub'],
            'kernel-console.class.stub' => ['kernel-console.class.stub'],
            'kernel-http.class.stub' => ['kernel-http.class.stub'],
            'loader-aliases.class.stub' => ['loader-aliases.class.stub'],
            'loader-middleware.class.stub'  => ['loader-middleware.class.stub'],
            'loader-providers.class.stub' => ['loader-providers.class.stub'],
            'middleware-encrypt-cookies.class.stub' => ['middleware-encrypt-cookies.class.stub'],
            'middleware-check-for-maintenance-mode.class.stub' => ['middleware-check-for-maintenance-mode.class.stub'],
            'middleware-redirect-If-authenticated.class.stub' => ['middleware-redirect-If-authenticated.class.stub'],
            'middleware-trim-strings.class.stub' => ['middleware-trim-strings.class.stub'],
            'middleware-trust-proxies.class.stub' => ['middleware-trust-proxies.class.stub'],
            'middleware-verify-csrf-token.class.stub' => ['middleware-verify-csrf-token.class.stub'],
            'provider-auth-service.class.stub' => ['provider-auth-service.class.stub'],
            'provider-broadcast-service.class.stub' => ['provider-broadcast-service.class.stub'],
            'provider-event-service.class.stub' => ['provider-event-service.class.stub'],
            'provider-route-service.class.stub' => ['provider-route-service.class.stub'],
            'route-home.stub' => ['route-home.stub'],
            'scope.interface.stub' => ['scope.interface.stub'],
            'test-functional-example.class.stub' => ['test-functional-example.class.stub'],
            'trait-creates-application.class.stub' => ['trait-creates-application.class.stub']
        ];
    }

    /**
     * @param string $filename
     *
     * @dataProvider provideStubsFilename
     * @return void
     */
    public function testGetStubMethod(string $filename): void
    {
        $this->assertFileExists($this->trait->getStub($filename));
    }

    /***
     * @return void
     */
    public function testSetStubVariableMethod(): void
    {
        $stubVariable = $this->trait->setStubVariable('class', 'ClassName');

        $this->assertEquals($stubVariable, $this->trait);
    }

    /**
     * @param string $filename
     *
     * @dataProvider provideStubsFilename
     * @return void
     */
    public function testGetStubContentsMethod(string $filename): void
    {
        $stubFile = $this->trait->getStub($filename);

        $this->assertIsString(
            $this->trait->getStubContents($stubFile)
        );
    }
}
