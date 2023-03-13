<?php

namespace AlxDorosenco\PortoForLaravel\Structure\Builder;

trait Components
{
    /**
     * @var array
     */
    protected $componentVariables = [];

    /**
     * @param string $filename
     * @return string
     */
    public function getComponent(string $filename): string
    {
        return __DIR__.'/components/'.$filename.'.json';
    }

    /**
     * @param string $component
     * @return array
     */
    protected function getComponentContents(string $component): array
    {
        $structureContent = file_get_contents($component);
        $structure = $this->convertFromJsonToArray($structureContent);

        return array_map(function ($data){
            return array_map(function ($v){
                return $this->componentVariablesReplacer($v);
            }, $data);
        }, $structure);
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    protected function setComponentVariable(string $key, string $value)
    {
        $this->componentVariables[$key] = $value;

        return $this;
    }

    /**
     * @param string $param
     * @return array|string|string[]
     */
    protected function componentVariablesReplacer(string $param)
    {
        foreach ($this->componentVariables as $search => $replace) {
            $param = str_replace('{'.$search.'}', $replace, $param);
        }

        return $param;
    }
}
