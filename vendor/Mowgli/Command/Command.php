<?php

namespace Mowgli\Command;

use \Symfony\Component\Console\Command\Command as BaseCommand;
use \Mowgli\Helper\DialogHelper;
use \Mowgli\Container\ContainerAware;
use \Mowgli\Container\Container;

class Command extends BaseCommand implements ContainerAware
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     *
     * @param Container $Container
     */
    public function setContainer(Container $Container)
    {
        $this->container = $Container;
    }

    /**
     * @return \Mowgli\Helper\DialogHelper;
     */
    protected function getDialogHelper()
    {
        return $this->getHelperSet()->get('dialog');
    }

    /**
     * @return \Mowgli\Helper\ServerHelper;
     */
    protected function getServerHelper()
    {
        return $this->getHelperSet()->get('server');
    }


    /**
     * @return \Symfony\Component\Console\Helper\FormatterHelper;
     */
    protected function getFormatterHelper()
    {
        return $this->getHelperSet()->get('formatter');
    }
  
    /**
     * @return bool
     */
    protected function isLaunchedWithPhar()
    {
        return $this->getApplication()->isLaunchedWithPhar();
    }
    

}
