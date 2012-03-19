<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Launcher extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'bin/launcher.php.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/bin/%s', $container['root_dir'], strtolower($container['application_name']));
    }

    /**
     * @param \sro\Mowgli\Container\Container $container
     *
     */
    protected function postGenerate()
    {
        chmod($this->getOutputFilePath(), 0777);
    }

    /**
     *
     * @return array
     */
    protected function getTemplateContext()
    {
        $container = $this->getOption('remote_project_container');
        return array(
            'namespace' => $container['namespace']
        );
    }

}
