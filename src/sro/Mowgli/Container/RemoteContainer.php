<?php

namespace sro\Mowgli\Container;

use Mowgli\Container\Container as BaseContainer;
use \sro\Mowgli\Remote\Configuration;

class RemoteContainer extends BaseContainer
{

    /**
     * @var \sro\Mowgli\Remote\Configuration
     */
    private $configuration;

    /**
     * @param \sro\Mowgli\Remote\Configuration $configuration
     * @param array                            $default
     */
    public function __construct(Configuration $configuration, array $default = array())
    {
        $this->setConfiguration($configuration);
        parent::__construct($default);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    function offsetGet($id)
    {
        return $this->getConfiguration()->get($id);
    }


    /**
     *
     * @return \sro\Mowgli\Remote\Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param \sro\Mowgli\Remote\Configuration $configuration
     *
     * @return \sro\Mowgli\Container\RemoteContainer
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

}
