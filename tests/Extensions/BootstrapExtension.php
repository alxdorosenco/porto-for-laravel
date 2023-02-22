<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Extensions;

use PHPUnit\Runner\AfterLastTestHook;

class BootstrapExtension implements AfterLastTestHook
{
    public function executeAfterLastTest(): void
    {
        $path = base_path().DIRECTORY_SEPARATOR.'PortoTestStructure';

        if(PHP_OS_FAMILY === 'Windows'){
            exec('rmdir /S /Q '. $path);
        } else {
            exec('rm -rf '. $path);
        }
    }
}
