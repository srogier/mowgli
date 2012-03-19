<?php

namespace sro\Mowgli\Command;

use Mowgli\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mowgli\Container\Container;
use sro\Mowgli\Generator\Project;
use sro\Mowgli\Validator\Validators;
use sro\Mowgli\Logger\OutputLogger;


/**
 * ListCommand displays the list of all available commands for the application.
 *
 */
class GenerateProject extends Command
{

    protected function configure()
    {
        $this
            ->setName('generate:project')
            ->setDefinition(array(
                new InputArgument('application_name', InputArgument::OPTIONAL, 'Application name'),
            ))
            ->setDescription('Generates scaffold for your project')
            ->setHelp(<<<EOF
The <info>generate:project</info> generates scaffold for your project and creates you a usable cli application:

    <info>mowgli generate:project</info>
    
You can set the application name by using the <comment>application_name</comment> argument:

    <info>mowgli generate:project Foo</info>
EOF
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog    = $this->getDialogHelper();
        $server    = $this->getServerHelper();
        $validator = $this->getProjectValidator();

        try 
        {
            $projectName = $input->getArgument('application_name');
            $validator->validateProjectName($projectName);
        }
        catch (\InvalidArgumentException $e)
        {
            $projectName = $dialog->askAndValidate(
                $output,
                $dialog->getQuestion('Application name'),
                array($validator, 'validateProjectName')
            );
        }
        
        //ask project directory
        $defaultDirectory = $this->guessProjectDirectory($projectName, $server->getPwd());
        $projectDirectory = $dialog->askAndValidate(
            $output,
            $dialog->getQuestion('Application directory', $defaultDirectory),
            array($validator, 'validateTargetDir'),
            true,
            $defaultDirectory
        );

        //ask base namespace
        $defaultNamespace = $this->guessNamespace($projectName);
        $projectNamespace = $dialog->askAndValidate(
            $output,
            $dialog->getQuestion('Application namespace', $defaultNamespace),
            array($validator, 'validateNamespace'),
            true,
            $defaultNamespace
        );

        $options = array(
            'remote_project_container' => new Container(array(
                'root_dir'         => $projectDirectory,
                'application_name' => $projectName,
                'namespace'        => $projectNamespace,
            ))
        );

        $generator = $this->getProjectGenerator($this->getContainer(), $options);
        $generator->setLogger($this->buildLogger($output));
        $generator->generate();
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
     * @param $projectName
     * @param $baseDir
     *
     * @return mixed|null
     */
    private function guessProjectDirectory($projectName, $baseDir)
    {
        return sprintf('%s/%s', $baseDir, $projectName);
    }

    /**
     * @param string $projectName
     *
     * @return string
     */
    private function guessNamespace($projectName)
    {
        return ucfirst($projectName);
    }

    /**
     * @param \Mowgli\Container\Container $container
     * @param array                       $options
     *
     * @return \sro\Mowgli\Generator\Project
     */
    private function getProjectGenerator(Container $container, $options = array())
    {
        return new Project($container, $options);
    }


    /**
     * @return \sro\Mowgli\Validator\Validators
     */
    private function getProjectValidator()
    {
        return new Validators();
    }

}
