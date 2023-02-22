<?php

namespace AlxDorosenco\PortoForLaravel\Structure\Builder;

trait Stubs
{
    /**
     * @var array|string[]
     */
    protected array $stubVariables = [];

    /**
     * @param string $filename
     * @return string
     */
    protected function getStub(string $filename): string
    {
        return __DIR__.'/stubs/'.$filename;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    protected function setStubVariable(string $key, string $value): static
    {
        $this->stubVariables[$key] = $value;

        return $this;
    }

    /**
     * @param string $stub
     * @return array|bool|string
     */
    public function getStubContents(string $stub): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($this->stubVariables as $search => $replace) {
            $contents = str_replace('{{ '.$search.' }}' , $replace, $contents);
        }

        return $contents;

    }
}
