<?php

namespace sro\Mowgli\Command;

use Symfony\Component\Console\Command\ListCommand as BaseListCommand;

class ListCommand extends BaseListCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
        
        $this
            ->setHelp(<<<EOF
The <info>list</info> command lists all commands:

  <info>mowgli list</info>

You can also display the commands for a specific namespace:

  <info>mowgli list test</info>

You can also output the information as XML by using the <comment>--xml</comment> option:

  <info>mowgli list --xml</info>

It's also possible to get raw list of commands (useful for embedding command runner):

  <info>mowgli list --raw</info>
EOF
            );
    }

}
