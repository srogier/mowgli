<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;
use \sro\Mowgli\Logger\LoggerInterface;

abstract class AbstractGenerator implements GeneratorInterface
{

    /**
     * @var \Mowgli\Container\Container
     */
    private $container;

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var \sro\Mowgli\Logger\LoggerInterface
     */
    private $logger;


    /**
     * @param \Mowgli\Container\Container $container
     * @param array                       $options
     */
    public function __construct(DataContainer $container, array $options = array())
    {
        $this
            ->setContainer($container)
            ->setOptions($options);
    }

    /**
     * @param string $message
     * @param string $level
     */
    protected function log($message, $level = 'info')
    {
        if (null !== $logger = $this->getLogger())
        {
            $logger->log($message, $level);
        }
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
     * @return \sro\Mowgli\Generator\AbstractGenerator
     */
    public function setContainer(\Mowgli\Container\Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function getOption($key)
    {
        if (!$this->hasOption($key))
        {
            throw new \InvalidArgumentException(sprintf('Unknow option {%s}', $key));
        }

        return $this->options[$key];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasOption($key)
    {
        return isset($this->options[$key]);
    }

    /**
     * @param array $options
     *
     * @return \sro\Mowgli\Generator\AbstractGenerator
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     *
     * @return \sro\Mowgli\Logger\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \sro\Mowgli\Logger\LoggerInterface $logger
     *
     * @return \sro\Mowgli\Generator\AbstractGenerator
     */
    public function setLogger(\sro\Mowgli\Logger\LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        return $this;
    }

}
