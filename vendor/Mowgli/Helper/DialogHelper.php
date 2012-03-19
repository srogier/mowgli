<?php

namespace Mowgli\Helper;

use Symfony\Component\Console\Helper\DialogHelper as BaseDialogHelper;

class DialogHelper extends BaseDialogHelper
{

    /**
     * @param string $question
     * @param mixed $default
     * @param string $sep
     *
     * @return string
     */
    public function getQuestion($question, $default = false, $sep = ':')
    {
        return $default ? sprintf('<info>%s</info> [<comment>%s</comment>]%s ', $question, $default, $sep) : sprintf('<info>%s</info>%s ', $question, $sep);
    }
}
