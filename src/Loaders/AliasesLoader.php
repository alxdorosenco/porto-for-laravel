<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use Illuminate\Support\Facades\App;

trait AliasesLoader
{
    /**
     * @return array
     */
    protected function getAliasesFromContainersLoaders(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Loaders');

        $aliases = [];
        foreach ($directories as $directory){
            $classLoader = $this->getClassFromFile($directory.DIRECTORY_SEPARATOR.'AliasesLoader.php');
            if(class_exists($classLoader)){
                $aliases += app($classLoader)->aliases;
            }
        }

        return $aliases;
    }

    /**
     * Load registered application, custom and containers aliases
     */
    protected function loadAliasesForRegister()
    {
        $aliases = $this->getAliasesFromContainersLoaders();

        foreach ($aliases as $name => $class){
            App::alias($class, $name);
        }
    }
}
