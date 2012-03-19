<?php

namespace sro\Mowgli\Generator;

use Mowgli\Container\Container as DataContainer;

abstract class TwigGenerator extends AbstractGenerator
{

    public function generate()
    {
        /** @var \Twig_Environment $twig  */
        /** @var \Symfony\Component\Filesystem\Filesystem $filesystem */
        $container  = $this->getContainer();
        $filesystem = $container['fs'];
        $twig       = $container['twig'];
        if (!$twig instanceof \Twig_Environment)
        {
            throw new \RuntimeException('A Twig object is required to run this generator');
        }

        //@TODO replace by a configuration file ??
        /** @var \Twig_Loader_Filesystem $twigLoader  */
        $twigLoader  = $container['twig_loader'];
        $templateDir = $this->getTemplateDirectory();
        if (!in_array($templateDir, $twigLoader->getPaths()))
        {
            $twigLoader->addPath($templateDir);
        }

        $content = $twig->render(
            $this->getTemplate(),
            $this->getTemplateContext()
        );

        $filePath      = $this->getOutputFilePath();
        $fileDirectory = dirname($filePath);
        if (!is_readable($fileDirectory))
        {
            $filesystem->mkdir($fileDirectory);
        }

        file_put_contents($filePath, $content);
        $this->log(sprintf('%s has been generated', $filePath));
        $this->postGenerate();
    }

    /**
     * @return string
     */
    private function getTemplateDirectory()
    {
        return sprintf('%s/../Templates', __DIR__);
    }

    /**
     * @abstract
     *
     * @return array
     */
    abstract protected function getTemplateContext();

    /**
     * @abstract
     * @return string
     */
    abstract protected function getTemplate();


    /**
     * @abstract
     *
     * @return string
     */
    abstract protected function getOutputFilePath();

    /**
     * Post generation hook
     *
     */
    protected function postGenerate()
    {
    }

}
