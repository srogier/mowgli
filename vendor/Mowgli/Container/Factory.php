<?php

namespace Mowgli\Container;

class Factory
{

    /**
     * @param array $options
     *
     * @return Container
     */
    public function build(array $options = array())
    {
        return new Container($options);
    }
}
 
