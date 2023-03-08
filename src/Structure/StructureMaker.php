<?php

namespace AlxDorosenco\PortoForLaravel\Structure;

use AlxDorosenco\PortoForLaravel\Structure\Builder\Structure;
use Illuminate\Console\Command;

class StructureMaker
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @var Structure
     */
    private $structure;

    /**
     * @param Command $command
     * @param Structure $structure
     */
    public function __construct(Command $command, Structure $structure)
    {
        $this->command = $command;
        $this->structure = $structure;
    }

    public function execute(): void
    {
        $this->structure->createRootDirectory();
        $this->structure->build();
        $this->structure->showInCli($this->command);
    }
}
