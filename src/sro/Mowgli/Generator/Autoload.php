<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Autoload extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'src/autoload.php.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/src/autoload.php', $container['root_dir']);
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
