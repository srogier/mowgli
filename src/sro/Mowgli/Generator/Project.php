<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;
use \sro\Mowgli\Remote\Configuration;

class Project extends AbstractGenerator
{

    /**
     * @var GeneratorFactory
     */
    private $factory;

    /**
     * @param \Mowgli\Container\Container $container
     * @param array                       $options
     * @param GeneratorFactory            $factory
     */
    public function __construct(DataContainer $container, array $options = array(), GeneratorFactory $factory = null)
    {
        if (null === $factory)
        {
            $factory = new GeneratorFactory();
        }

        $this->setFactory($factory);

        parent::__construct($container, $options);
    }

    public function generate()
    {
        $options   = $this->getOptions();
        //check options

        //check if project is already a project build by Mowgli project
        $rootDir = $options['remote_project_container']['root_dir'];
        if (is_dir($rootDir))
        {
            throw new \RuntimeException(sprintf('The directory %s is existing', $rootDir));
        }
        //create vendor directory
        $vendorDirectory = $this->createVendorDirectory();
        $this->log(sprintf('%s has been created', $vendorDirectory));
        
        //create src directory
        $srcDirectory = $this->createSrcDirectoryTree($options['remote_project_container']['src_directory']);
        $this->log(sprintf('%s has been created', $srcDirectory));

        $commonGenerator = array(
            'Application',
            'Container',
            'ContainerFactory',
            'Config',
            'Autoload',
            'CommandList',
            'Launcher',
            'Flag',
        );

        $generatorFactory = $this->getFactory();
        foreach ($commonGenerator as $generator)
        {
            $generatorFactory
                ->build($generator, $this->getContainer(), $this->getOptions())
                ->setLogger($this->getLogger())
                ->generate();
        }

        $commands = array('help', 'listCommand', 'config', 'compile', 'install');
        foreach ($commands as $command)
        {
            $generatorFactory
                ->build('Command', $this->getContainer(), array_merge($this->getOptions(), array('new_command_name' => $command)))
                ->setLogger($this->getLogger())
                ->generate();
        }
    }

    /**
     * @param $srcDirectory
     *
     * @return mixed
     */
    protected function createSrcDirectoryTree($srcDirectory)
    {
        /** @var $filesystem \Symfony\Component\Filesystem\Filesystem */
        $container  = $this->getContainer();
        $filesystem = $container['fs'];
        $filesystem->mkdir($srcDirectory);

        return $srcDirectory;
    }

    /**
     * 
     * @return string
     */
    protected function createVendorDirectory()
    {
        $options         = $this->getOptions();
        $container       = $this->getContainer();
        /** @var $filesystem \Symfony\Component\Filesystem\Filesystem */
        $filesystem = $container['fs'];
        $vendorDirectory = $options['remote_project_container']['root_dir'] . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR;

        $filesystem->mkdir($vendorDirectory);
        $filesystem->mirror(
            $container['root_dir'] . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'Mowgli'. DIRECTORY_SEPARATOR,
            $vendorDirectory  . DIRECTORY_SEPARATOR . 'Mowgli'
        );
        
        return $vendorDirectory;
    }

    /**
     *
     * @return \sro\Mowgli\Generator\GeneratorFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param \sro\Mowgli\Generator\GeneratorFactory $factory
     *
     * @return $this;
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;

        return $this;
    }

}

