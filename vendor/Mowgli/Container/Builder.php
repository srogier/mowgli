<?php

namespace Mowgli\Container;

use \Symfony\Component\Yaml\Yaml;

class Builder
{

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var array
     */
    private $confFiles = array();
    
    /**
     * @var Factory
     */
    private $factory; 

    /**
     * @param Factory|null $factory
     */
    public function __construct(Factory $factory = null)
    {
        if (null === $factory)
        {
            $factory = new Factory();
        }
        
        $this->setFactory($factory);
    }

    /**
     * @return Container
     */
    public function build()
    {
        $options = $this->getOptions();

        foreach ($this->getConfFiles() as $file)
        {
            $options = array_merge(
                $options, 
                $this->retrieveOptionsFromConfFile($file['path'], $file['key'])
            );
        }
        
        return $this->getFactory()->build($options);
    }

    /**
     * @param string $confFile
     * @param string $key
     *
     * @return array
     */
    private function retrieveOptionsFromConfFile($confFile, $key)
    {
        $yaml = Yaml::parse($confFile);
        return isset($yaml[$key]) ? $yaml[$key] : array();
    }


    /**
     * @param $confFile
     * @param $key
     *
     * @return \Mowgli\Container\Builder
     * @throws \InvalidArgumentException
     */
    public function addConfFile($confFile, $key)
    {
        if (!is_readable($confFile))
        {
            throw new \InvalidArgumentException(sprintf('Unable to read %s', $confFile));
        }

        $this->confFiles[] = array(
            'path' => $confFile,
            'key'  => $key
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return \Mowgli\Container\Builder
     */
    public function addOptions(array $options)
    {
        $this->setOptions(array_merge($this->getOptions(), $options));

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Builder
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getConfFiles()
    {
        return $this->confFiles;
    }

    /**
     * @param array $confFiles
     *
     * @return \Mowgli\Container\Builder
     */
    public function setConfFiles(array $confFiles)
    {
        $this->confFiles = $confFiles;

        return $this;
    }

    /**
     *
     * @return \Mowgli\Container\Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param \Mowgli\Container\Factory $factory
     */
    public function setFactory(\Mowgli\Container\Factory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

}
