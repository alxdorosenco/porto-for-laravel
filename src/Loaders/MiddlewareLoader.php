<?php

namespace AlxDorosenco\PortoForLaravel\Loaders;

use Illuminate\Foundation\Http\Kernel;

trait MiddlewareLoader
{
    /**
     * @return array
     */
    private function getMiddlewareClassesLoadersFromContainers(): array
    {
        $directories = $this->findDirectories(config('porto.root').DIRECTORY_SEPARATOR.'Containers', 'Loaders');

        $classLoaders = [];
        foreach ($directories as $directory){
            $classLoader = $this->getClassFromFile($directory.DIRECTORY_SEPARATOR.'MiddlewareLoader.php');
            !class_exists($classLoader) ?: $classLoaders[] = $classLoader;
        }

        return $classLoaders;
    }

    /**
     * @return array
     */
    private function getMiddlewareFromClassesLoaders(): array
    {
        $classesLoaders = $this->getMiddlewareClassesLoadersFromContainers();

        $middlewares = [];
        foreach ($classesLoaders as $classLoader){
            $middlewares[] = array_merge($middlewares, [
                'middleware'         => app($classLoader)->middleware,
                'middlewareGroups'   => app($classLoader)->middlewareGroups,
                'routeMiddleware'    => app($classLoader)->routeMiddleware,
                'middlewarePriority' => app($classLoader)->middlewarePriority
            ]);
        }

        return $middlewares;
    }

    /**
     * Load registered middlewares from containers
     */
    protected function loadMiddlewareForRegister()
    {
        $middlewares = $this->getMiddlewareFromClassesLoaders();

        foreach ($middlewares as $middlewareData){
            foreach ($middlewareData['middleware'] as $middlewareClass){
                app(Kernel::class)->pushMiddleware($middlewareClass);
            }

            foreach ($middlewareData['middlewareGroups'] as $groupName => $middlewareGroup){
                foreach ($middlewareGroup as $middlewareClass){
                    app('router')->pushMiddlewareToGroup($groupName, $middlewareClass);
                }
            }

            foreach ($middlewareData['routeMiddleware'] as $aliasName => $middlewareClass){
                app('router')->aliasMiddleware($aliasName, $middlewareClass);
            }

            foreach ($middlewareData['middlewarePriority'] as $middlewareClass) {
                if (!in_array($middlewareClass, app('router')->middlewarePriority, true)) {
                    app('router')->middlewarePriority[] = $middlewareClass;
                }
            }
        }
    }
}
