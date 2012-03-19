<?php

namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;
use \Symfony\Component\Yaml\Yaml;

class CommandList extends TwigGenerator
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'config/commands.yml.twig';
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/config/commands.yml', $container['root_dir']);
    }

    /**
     *
     * @return array
     */
    protected function getTemplateContext()
    {
        $commands = array();
        $container = $this->getOption('remote_project_container');
        $remoteCommandListPath = $this->getOutputFilePath();
        if (is_readable($remoteCommandListPath))
        {
            $datas = Yaml::parse($remoteCommandListPath);
            if (isset($datas['commands']))
            {
                $commands = $datas['commands'];
            }
        }
        
        if ($this->hasOption('new_command_name'))
        {
            $commands[] = sprintf(
                '%s\Command\%s',
                $container['namespace'],
                $this->getOption('new_class_name')
            );
        }
        return array(
            'commands' => $commands
        );
    }

}