<?php

namespace sro\Mowgli;

use Mowgli\Application as BaseApplication;
use sro\Mowgli\Helper\GeneratorHelper;

class Application extends BaseApplication
{

    /**
     * @return \Symfony\Component\Console\Helper\HelperSet
     */
    protected function getDefaultHelperSet()
    {
        $helperSet = parent::getDefaultHelperSet();
        $helperSet->set(new GeneratorHelper());
        
        return $helperSet;
    }
}
