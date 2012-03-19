<?php


namespace sro\Mowgli\Generator;

use \Mowgli\Container\Container as DataContainer;

class Command extends TwigGenerator
{

    /**
     *
     */
    public function generate()
    {
        $options                   = $this->getOptions();
        $options['new_class_name'] = $this->buildClassName($options['new_command_name']);
        $this->setOptions($options);

        parent::generate();
    }


    /**
     * @param string $commandName
     *
     * @return string
     */
    private function buildClassName($commandName)
    {
        return ucfirst(str_replace(array('_', '-', ':'), '', $commandName));
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        $container = $this->getContainer();
        /** @var \Twig_Loader_Filesystem $twigLoader  */
        $twigLoader = $container['twig_loader'];

        try
        {
            $template = sprintf(
                'src/Commands/%s.php.twig',
                $this->getOption('new_class_name')
            );

            $twigLoader->getCacheKey($template);
        }
        catch (\Twig_Error_Loader $e)
        {
            $template = 'src/Command.php.twig';
        }

        return $template;
    }

    /**
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $container = $this->getOption('remote_project_container');
        return sprintf('%s/Command/%s.php',
            $container['src_directory'],
            $this->getOption('new_class_name')
        );
    }

    /**
     *
     */
    protected function postGenerate()
    {
        //register this command in the command list of the project
        $this
            ->getGeneratorFactory()
            ->build('CommandList', $this->getContainer(), $this->getOptions())
            ->generate();
    }

    /**
     * @return GeneratorFactory
     */
    private function getGeneratorFactory()
    {
        return new GeneratorFactory();
    }

    /**
     *
     * @return array
     */
    protected function getTemplateContext()
    {
        $container = $this->getOption('remote_project_container');
        return array(
            'class_name'           => $this->getOption('new_class_name'),
            'command_name'         => $this->getOption('new_command_name'),
            'application_launcher' => $container['application_name'],
            'namespace'            => $container['namespace'],
        );
    }

}
