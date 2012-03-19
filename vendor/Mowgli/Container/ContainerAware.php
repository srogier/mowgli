<?php

namespace Mowgli\Container;


interface ContainerAware
{

    /**
     * @abstract
     *
     * @return Container;
     */
    public function getContainer();


    /**
     * @abstract
     *
     * @param \Mowgli\Container\Container $container
     */
    public function setContainer(Container $container);
}
