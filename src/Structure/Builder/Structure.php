<?php

namespace AlxDorosenco\PortoForLaravel\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use Illuminate\Console\Command;

use Illuminate\Console\View\Components\TwoColumnDetail;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Console\Helper\Table;

abstract class Structure
{
    use Stubs;
    use Components;
    use FilesAndDirectories;

    /**
     * @return string
     */
    public function createRootDirectory(): string
    {
        return $this->createDirectory($this->componentVariables['path']);
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return $this->componentVariables['path'];
    }

    public function build(): void
    {
        foreach ($this->getStructure() as $data){
            $builder = clone $this;
            foreach ($data as $key => $value){
                $builder->setStubVariable($key, $value);
            }

            $stubVariables = $builder->stubVariables;

            if(!empty($stubVariables['directory'])){
                $builder->createDirectory($stubVariables['directory']);
                if(!empty($stubVariables['template'])){
                    $stubPath = $builder->getStub($stubVariables['template']);
                    if($builder->findExistingFile($stubPath)){
                        $stubContent = $builder->getStubContents($stubPath);

                        $filename = ($stubVariables['file'] ?? $stubVariables['class'] ?? $stubVariables['interface']).'.php';
                        $filePath = $stubVariables['directory'].DIRECTORY_SEPARATOR.$filename;

                        $builder->makeFile($filePath, $stubContent);
                    }
                }
            }
        }
    }

    /**
     * @param Command $command
     */
    public function showInCli(Command $command): void
    {
        $structureData = $this->getStructure();
        array_unshift($structureData, ['directory' => $this->getRootDirectory()]);

        $rows = [];
        foreach ($structureData as $data){
            $directory = $data['directory'];
            $file = $data['file'] ?? $data['class'] ?? null;
            !$file ?: $file = DIRECTORY_SEPARATOR.$file.'.php';

            $rows[] = ['path' => $directory.$file, 'status' => 'DONE'];
        }

        $table = with(new Table($command->getOutput()));
        $table->setHeaders(['Path', 'Status'])->setRows($rows)->setStyle('default');
        $table->render();
    }

    /**
     * @return array
     */
    abstract public function getStructure(): array;
}
