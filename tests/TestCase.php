<?php

namespace AlxDorosenco\PortoForLaravel\Tests;

use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use CreatesApplication;

    protected string $portoPath = 'PortoTestStructure';

    protected string $containerName = 'Standard';

    public function setUp(): void
    {
        parent::setUp();

        config([
            'porto.enabled' => true,
            'porto.path' => $this->portoPath,
            'porto.root' => base_path($this->portoPath)
        ]);
    }

    public function tearDown(): void
    {
        config([
            'porto.path' => null,
            'porto.root' => null
        ]);

        parent::tearDown();
    }
}
