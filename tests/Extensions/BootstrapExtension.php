<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Extensions;

use PHPUnit\Runner\AfterLastTestHook;

class BootstrapExtension implements AfterLastTestHook
{
    public function executeAfterLastTest(): void
    {
        $shipPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Ship';
        $containersPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Containers';

        if(PHP_OS_FAMILY === 'Windows'){
            exec('rmdir /S /Q '. $shipPath);
            exec('rmdir /S /Q '. $containersPath);
        } else {
            exec('rm -rf '. $shipPath);
            exec('rm -rf '. $containersPath);
        }

        exec('composer dump-autoload');
    }
}
