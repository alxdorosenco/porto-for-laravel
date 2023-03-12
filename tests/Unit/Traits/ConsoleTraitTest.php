<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Traits;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\Console;

class ConsoleTraitTest extends TestCase
{
    /**
     * @var __anonymous@388
     */
    private $trait;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use Console {
                getPath as public;
                getNamespaceRequest as public;
                getNamespaceResponse as public;
                getNamespaceRedirectResponse as public;
                rootNamespace as public;
                getContainersNamespace as public;
                getShipNamespace as public;
            }
        };
    }

    /***
     * @return void
     */
    public function testGetPathMethod()
    {
        $isString = is_string($this->trait->getPath('test'));
        $this->assertTrue($isString);
    }

    /**
     * @return void
     */
    public function testGetNamespaceRequestMethod()
    {
        $isString = is_string($this->trait->getNamespaceRequest());
        $this->assertTrue($isString);
    }

    /**
     * @return void
     */
    public function testGetNamespaceResponseMethod()
    {
        $isString = is_string($this->trait->getNamespaceResponse());
        $this->assertTrue($isString);
    }

    /**
     * @return void
     */
    public function testGetNamespaceRedirectResponseMethod()
    {
        $isString = is_string($this->trait->getNamespaceRedirectResponse());
        $this->assertTrue($isString);
    }

    /***
     * @return void
     */
    public function testRootNamespaceMethod()
    {
        $isString = is_string($this->trait->rootNamespace());
        $this->assertTrue($isString);
    }

    /***
     * @return void
     */
    public function testGetContainersNamespaceMethod()
    {
        $isString = is_string($this->trait->getContainersNamespace());
        $this->assertTrue($isString);
    }

    /***
     * @return void
     */
    public function testGetShipNamespaceMethod()
    {
        $isString = is_string($this->trait->getShipNamespace());
        $this->assertTrue($isString);
    }
}
