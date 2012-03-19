<?php

namespace Mowgli\Command\Collection;

use \Symfony\Component\Console\Command\Command;

class Collection
{

    /**
     * @var Symfony\Component\Console\Command\Command[]
     */
    private $commands = array();

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     */
    public function registerCommand(Command $command)
    {
        $this->commands[] = $command;
    }

    /**
     * @return Symfony\Component\Console\Command\Command[]
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param Symfony\Component\Console\Command\Command[] $commands
     *
     * @return Collection
     */
    public function setCommands(array $commands)
    {
        foreach ($commands as $command)
        {
            $this->registerCommand($command);
        }

        return $this;
    }
}
