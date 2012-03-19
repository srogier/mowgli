<?php


namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Container extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'src/Container/Container.php.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/Container/Container.php', $container['src_directory']);
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
