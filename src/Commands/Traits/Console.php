<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Traits;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Support\Str;

trait Console
{
    use FilesAndDirectories;

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return config('porto.root').DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
    }

    /**
     * @return string
     */
    protected function getNamespaceRequest(): string
    {
        return $this->getShipNamespace().'\Requests\\Request';
    }

    /**
     * @return string
     */
    protected function getNamespaceResponse(): string
    {
        return $this->getShipNamespace().'\Responses\\Response';
    }

    /**
     * @return string
     */
    protected function getNamespaceRedirectResponse(): string
    {
        return $this->getShipNamespace().'\Responses\\RedirectResponse';
    }

    /**
     * @return string
     */
    protected function getNecessaryNamespace(): string
    {
        if($container = $this->option('container')){
            $containerNamespace = $this->getNamespaceFromPath($container);

            return $this->getContainersNamespace().'\\'.$containerNamespace;
        }

        return $this->getShipNamespace();
    }

    /**
     * @return string
     */
    protected function rootNamespace(): string
    {
        return $this->getNamespaceFromPath(config('porto.path')).'\\';
    }

    /**
     * @return string
     */
    protected function getContainersNamespace(): string
    {
        return $this->rootNamespace().'Containers';
    }

    /**
     * @return string
     */
    protected function getShipNamespace(): string
    {
        return $this->rootNamespace().'Ship';
    }
}
