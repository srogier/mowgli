<?php

namespace Mowgli\Helper;

use Symfony\Component\Console\Helper\Helper;

class ServerHelper extends Helper
{
    /**
     * @return string
     */
    public function getPwd()
    {
        return isset($_SERVER['PWD']) ? $_SERVER['PWD'] : getcwd();
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    function getName()
    {
        return 'server';
    }
}
