<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Loaders;

use AlxDorosenco\PortoForLaravel\Loaders\HelpersLoader;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class HelpersLoaderTraitTest extends TestCase
{
    /**
     * @var __anonymous@402
     */
    private $trait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use HelpersLoader {
                getHelpersFromShip as public;
                getHelpersFromContainers as public;
            }
        };
    }

    public function testGetHelpersFromShipMethod(): void
    {
        $this->assertIsArray($this->trait->getHelpersFromShip());
    }

    public function testGetHelpersFromContainersMethod(): void
    {
        $this->assertIsArray($this->trait->getHelpersFromContainers());
    }
}
