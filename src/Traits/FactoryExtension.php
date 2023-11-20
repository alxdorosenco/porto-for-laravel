<?php

namespace AlxDorosenco\PortoForLaravel\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

trait FactoryExtension
{
    use FilesAndDirectories;

    /**
     * @return Factory|null
     */
    protected static function newFactory()
    {
        $object = new static();
        $namespace = $object->getNamespaceFromPath(config('porto.path')).'\\Containers\\';

        $factories = $object->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers','Data'.DIRECTORY_SEPARATOR.'Factories');
        $factories = $object->findFilesInDirectories($factories);

        $factoryNamespace = null;
        foreach ($factories as $factory){
            $containerNameArray = $object->findAndChainBetween($factory, 'Containers', '(Data)(\\\\|\/)(Factories)');
            if(!empty($containerNameArray[0])) {
                $containerNamespace = $object->getNamespaceFromPath($namespace.$containerNameArray[0]);
                if(!Str::startsWith($object::class, $containerNamespace.'\\Models\\')) {
                    continue;
                }

                $factoryNamespace = $containerNamespace.'\\Data\\Factories\\';
            }
        }

        if(!$factoryNamespace) {
            return null;
        }

        Factory::useNamespace($factoryNamespace);
        $className = class_basename($object::class);

        if (!class_exists($factoryNamespace . $className . 'Factory')) {
            return null;
        }

        return Factory::factoryForModel($className);
    }
}
