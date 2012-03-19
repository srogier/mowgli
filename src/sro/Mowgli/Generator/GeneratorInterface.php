<?php

namespace sro\Mowgli\Generator;

use Mowgli\Container\Container as DataContainer;

interface GeneratorInterface
{
    /**
     * @abstract
     */
    public function generate();
    
    /**
     * @abstract
     * 
     * @return array
     */
    public function getOptions();

    /**
     *
     * @return \Mowgli\Container\Container
     */
    public function getContainer();
    
}
