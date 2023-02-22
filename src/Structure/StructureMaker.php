<?php

namespace AlxDorosenco\PortoForLaravel\Structure;

use AlxDorosenco\PortoForLaravel\Structure\Builder\Structure;
use Illuminate\Console\Command;

class StructureMaker
{
    /**
     * @param Command $command
     * @param Structure $structure
     */
    public function __construct(
        private Command $command,
        private Structure $structure
    ) {}

    public function execute(): void
    {
        $this->structure->createRootDirectory();
        $this->structure->build();
        $this->structure->showInCli($this->command);
    }
}
