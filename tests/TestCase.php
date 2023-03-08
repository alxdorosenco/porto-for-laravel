<?php

namespace AlxDorosenco\PortoForLaravel\Tests;

use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use CreatesApplication;

    protected $portoPath = 'app';

    protected $containerName = 'Standard';

    public function setUp(): void
    {
        parent::setUp();

        config(['porto.path' => $this->portoPath]);
        config(['porto.root' => base_path($this->portoPath)]);
    }

    public function tearDown(): void
    {
        config(['porto.path' => null]);
        config(['porto.root' => null]);

        parent::tearDown();
    }
}
