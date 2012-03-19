<?php

namespace sro\Mowgli\Command;

use \Mowgli\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Input\InputArgument;
use \sro\Mowgli\Generator\GeneratorFactory;
use \sro\Mowgli\Remote\Configuration;
use \sro\Mowgli\Container\RemoteContainer;
use \sro\Mowgli\Logger\OutputLogger;

class GenerateCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('generate:command')
            ->setDescription('Generates a command in your project')
            ->setDefinition(array(
                new InputArgument('command_name', InputArgument::REQUIRED, 'The command name'),
            ))
            ->setHelp(<<<EOF
The <info>generate:command</info> generates a command in your project:

    <info>mowgli generate:command Foo</info>
EOF
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options             = array();
        $server              = $this->getServerHelper();
        $container           = $this->getContainer();
        $remoteConfiguration = new Configuration($server->getPwd());

        $commandName = $input->getArgument('command_name');
        $this->validateCommandName($commandName);
        
        $options['new_command_name']         = $commandName;
        $options['remote_project_container'] = new RemoteContainer($remoteConfiguration);

        $this
            ->getGeneratorFactory()
            ->build('Command', $container, $options)
            ->setLogger($this->buildLogger($output))
            ->generate();

    }

    
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return \sro\Mowgli\Logger\OutputLogger
     */
    private function buildLogger(OutputInterface $output)
    {
        return new OutputLogger($output, $this->getFormatterHelper());
    }

    
    /**
     * @param $commandName
     * @return mixed
     */
    public function validateCommandName($name)
    {
        if (!preg_match('/^[^\:]+(\:[^\:]+)*$/', $name)) {
            throw new \InvalidArgumentException(sprintf('Command name "%s" is invalid.', $name));
        }
        
        //avoid every spec char except : _ -
        //avoid command starting with digit
        
    }
    
    /**
     *
     * @return \sro\Mowgli\Generator\GeneratorFactory
     */
    private function getGeneratorFactory()
    {
        return new GeneratorFactory();
    }

    
}
