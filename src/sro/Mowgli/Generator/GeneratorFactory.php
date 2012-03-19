<?php

namespace sro\Mowgli\Generator;

use Mowgli\Container\Container as DataContainer;

class GeneratorFactory
{

    /**
     * @param string                      $name
     * @param \Mowgli\Container\Container $container
     * @param array                       $options
     *
     * @return AbstractGenerator
     * @throws \LogicException
     */
    public function build($name, DataContainer $container, array $options = array())
    {
        $className = $this->computeClassName($name);
        if (!class_exists($className))
        {
            throw new \LogicException(sprintf('Unknown class %s', $className));
        }

        return new $className($container, $options);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function computeClassName($name)
    {
        return sprintf('%s\%s', __NAMESPACE__, $name);
    }
}
