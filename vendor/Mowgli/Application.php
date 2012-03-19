<?php

namespace Mowgli;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Shell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\FormatterHelper;
use Mowgli\Helper\DialogHelper;
use Mowgli\Helper\ServerHelper;
use Mowgli\Command\Collection\Collection as CommandCollection;
use Mowgli\Command\Collection\Factory as CommandCollectionFactory;
use Mowgli\Container\Container;
use Mowgli\Container\ContainerAware;

abstract class Application extends BaseApplication implements ContainerAware
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var \Mowgli\Command\Collection\Collection
     */
    private $commandCollection;

    /**
     * @var \Mowgli\Command\Collection\Factory
     */
    private $commandCollectionFactory;

    /**
     * @param Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);

        $this->initializeCommandCollection();

        parent::__construct($container['application_name'], $container['version']);

        $this->getDefinition()->addOption(new InputOption('--shell', '-s', InputOption::VALUE_NONE, 'Launch the shell.'));
    }


    protected function initializeCommandCollection()
    {
        $container = $this->getContainer();
        if (null === $this->getCommandCollectionFactory())
        {
            $this->setCommandCollectionFactory(new CommandCollectionFactory());
        }
        
        $this->setCommandCollection(
            $this->getCommandCollectionFactory()->buildFromYml($container['commands_file_path'])
        );
    }


    /**
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return Command|\Symfony\Component\Console\Command
     */
    public function add(Command $command)
    {
        $command = parent::add($command);

        if (null !== $command && $command instanceof ContainerAware)
        {
            $command->setContainer($this->getContainer());
        }

        return $command;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (true === $input->hasParameterOption(array('--shell', '-s'))) {
            $shell = new Shell($this);
            $shell->run();

            return 0;
        }
        
        return parent::doRun($input, $output);
    }

    /**
     * @return bool
     */
    public function isLaunchedWithPhar()
    {
      return 'phar://' === substr($this->container['root_dir'], 0, 7);
    }

    /**
     * @return array
     */
    protected function getDefaultCommands()
    {
        return $this->getCommandCollection()->getCommands();
    }

    /**
     * Gets the default helper set with the helpers that should always be available.
     * 
     * @return \Symfony\Component\Console\Helper\HelperSet
     */
    protected function getDefaultHelperSet()
    {
        return new HelperSet(array(
            new FormatterHelper(),
            new DialogHelper(),
            new ServerHelper(),
        ));
    }

    /**
     *
     * @return \Mowgli\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Mowgli\Container\Container $container
     *
     * @return \Mowgli\Application
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     *
     * @return \Mowgli\Command\Collection\Collection
     */
    public function getCommandCollection()
    {
        return $this->commandCollection;
    }

    /**
     * @param \Mowgli\Command\Collection\Collection $commandCollection
     *
     * @return \Mowgli\Application
     */
    public function setCommandCollection(CommandCollection $commandCollection)
    {
        $this->commandCollection = $commandCollection;

        return $this;
    }

    /**
     *
     * @return \Mowgli\Command\Collection\Factory
     */
    public function getCommandCollectionFactory()
    {
        return $this->commandCollectionFactory;
    }

    /**
     * @param \Mowgli\Command\Collection\Factory $commandCollectionFactory
     *
     * @return \Mowgli\Application
     */
    public function setCommandCollectionFactory(CommandCollectionFactory $commandCollectionFactory)
    {
        $this->commandCollectionFactory = $commandCollectionFactory;

        return $this;
    }

}
