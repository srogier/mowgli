<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Application extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'src/Application.php.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/Application.php', $container['src_directory']);
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
