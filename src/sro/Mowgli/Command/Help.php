<?php

namespace sro\Mowgli\Command;

use Symfony\Component\Console\Command\HelpCommand as BaseHelpCommand;

class Help extends BaseHelpCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setHelp(<<<EOF
The <info>help</info> command displays help for a given command:

  <info>mowgli help list</info>

You can also output the help as XML by using the <comment>--xml</comment> option:

  <info>mowgli help --xml list</info>
EOF
            );
    }

}
