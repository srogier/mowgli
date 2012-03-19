<?php

namespace sro\Mowgli\Container;

use Mowgli\Container\Container as BaseContainer;

class Container extends BaseContainer
{

    /**
     *
     */
    protected function initialize()
    {
        $this['application_name'] = 'Mowgli';
        $this['version']          = 'DEV';
        $this['namespace']        = 'sro\Mowgli';

        $this['twig_loader'] = new \Twig_Loader_Filesystem(array());
        $this['twig']        = $this->share(function ($c)  {
            return new \Twig_Environment($c['twig_loader']);
        });
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this['twig'];
    }
}
