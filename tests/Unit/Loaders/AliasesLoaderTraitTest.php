<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Loaders;

use AlxDorosenco\PortoForLaravel\Loaders\AliasesLoader;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class AliasesLoaderTraitTest extends TestCase
{
    /**
     * @var __anonymous@472
     */
    private $trait;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->trait = new class {
            use FilesAndDirectories;
            use AliasesLoader {
                getAliasesFromContainersLoaders as public;
            }
        };
    }

    public function testGetAliasesFromContainersLoadersMethod()
    {
        $isArray = is_array($this->trait->getAliasesFromContainersLoaders());
        $this->assertTrue($isArray);
    }
}
