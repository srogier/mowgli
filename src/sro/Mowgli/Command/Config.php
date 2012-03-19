<?php

namespace sro\Mowgli\Command;

use Mowgli\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Mowgli\Container\Container;


/**
 * ListCommand displays the list of all available commands for the application.
 *
 */
class Config extends Command
{

    protected function configure()
    {
        $this
            ->setName('config')
            ->setDescription('Gets application\'s option value  ')
            ->setDefinition(array(
                new InputArgument('parameter_name', InputArgument::REQUIRED, 'The parameter name'),
            ))
            ->setHelp(<<<EOF
The <info>config</info> command gets application's option value.

    <info>mowgli config foo</info>

EOF
        );

    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $parameterName = $input->getArgument('parameter_name');
        
        if (!isset($container[$parameterName]))
        {
            throw new \InvalidArgumentException(sprintf('Unknown key configuration [%s]', $parameterName));
        }

        if (!is_scalar($container[$parameterName]))
        {
            throw new \UnexpectedValueException(sprintf("Can't display [%s] : this is not a scalar value", $parameterName));
        }
        
        $output->writeln($container[$parameterName]);
        return 0;
    }


}
