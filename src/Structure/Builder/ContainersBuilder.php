<?php

namespace AlxDorosenco\PortoForLaravel\Structure\Builder;

class ContainersBuilder extends Structure
{
    /**
     * @var string|null
     */
    private ?string $containerName = null;

    /**
     * @var string|null
     */
    private ?string $containerType = null;

    /**
     * @param string $path
     * @param string $namespace
     */
    public function __construct(string $path, string $namespace)
    {
        $this->setComponentVariable('path', $path.'/Containers');
        $this->setComponentVariable('namespace', $namespace.'\Containers');
        $this->setComponentVariable('rootNamespace', $namespace);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setContainerName(string $name): static
    {
        $this->containerName = $name;

        $this->setComponentVariable('path', $this->componentVariables['path'].'/'.$name);
        $this->setComponentVariable('namespace', $this->componentVariables['namespace'].'\\'.$this->getNamespaceFromPath($name));

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerName(): string
    {
        return $this->containerName;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setContainerType(string $name): static
    {
        $this->containerType = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerType(): string
    {
        return $this->containerType;
    }

    /**
     * @throws \JsonException
     */
    public function getStructure(): array
    {
        $structure = [];

        if(!$this->containerName){
            return $structure;
        }

        $structureComponent = $this->getComponent('container-'.$this->getContainerType());

        if($this->findExistingFile($structureComponent)){
            $structure = $this->getComponentContents($structureComponent);
        }

        return $structure;
    }
}
