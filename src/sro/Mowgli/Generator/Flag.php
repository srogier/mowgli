<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Flag extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'flag.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/.mowgli', $container['root_dir']);
    }


    /**
     *
     * @return array
     */
    protected function getTemplateContext()
    {
        $container = $this->getOption('remote_project_container');
        return array(
            'application_name' =>strtolower($container['application_name'])
        );
    }

}
