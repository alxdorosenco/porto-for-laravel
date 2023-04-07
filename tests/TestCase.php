<?php

namespace AlxDorosenco\PortoForLaravel\Tests;

use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use CreatesApplication;

    protected $portoPath = 'app';

    protected $containerName = 'Standard';

    public function setUp()
    {
        parent::setUp();

        config([
            'porto.enabled' => true,
            'porto.path' => $this->portoPath,
            'porto.root' => base_path($this->portoPath)
        ]);
    }

    public function tearDown()
    {
        config([
            'porto.path' => null,
            'porto.root' => null
        ]);

        parent::tearDown();
    }

    /**
     * @return string
     */
    protected function portoPathUcFirst(): string
    {
        return ucfirst($this->portoPath);
    }
}
