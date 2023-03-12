<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Loaders;

use AlxDorosenco\PortoForLaravel\Loaders\ProvidersLoader;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class ProvidersLoaderTraitTest extends TestCase
{
    /**
     * @var __anonymous@406
     */
    private $trait;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use FilesAndDirectories;
            use ProvidersLoader {
                getProvidersFromShip as public;
                getProvidersFromContainers as public;
                getProvidersFromContainersLoaders as public;
            }
        };
    }

    public function testGetProvidersFromShipMethod()
    {
        $isArray = is_array($this->trait->getProvidersFromShip());
        $this->assertTrue($isArray);
    }

    public function testGetProvidersFromContainers()
    {
        $isArray = is_array($this->trait->getProvidersFromContainers());
        $this->assertTrue($isArray);
    }

    public function testGetProvidersFromContainersLoaders()
    {
        $isArray = is_array($this->trait->getProvidersFromContainersLoaders());
        $this->assertTrue($isArray);
    }
}
