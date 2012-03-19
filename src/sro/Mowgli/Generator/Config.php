<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;
use \Symfony\Component\Yaml\Yaml;

class Config extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'config/config.yml.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/config/config.yml', $container['root_dir']);
    }

    /**
     *
     * @return array
     */
    protected function getTemplateContext()
    {
        $container = $this->getOption('remote_project_container');
        return array(
            'namespace' => $container['namespace'],
            'application_name' => $container['application_name'],
        );
    }

}