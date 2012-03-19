<?php

namespace Mowgli\Container;

use \Symfony\Component\Filesystem\Filesystem;
use \Symfony\Component\Process\ProcessBuilder;

class Container extends \Pimple
{

    /**
     * @param array $default
     */
    public function __construct(array $default = array())
    {
        $this['src_directory'] = $this->share(function($c) {
            $namespaceToPath = str_replace('\\', DIRECTORY_SEPARATOR, $c['namespace']);
            return sprintf('%s%ssrc%s%s', $c['root_dir'], DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $namespaceToPath);
        });

        $this['commands_file_path'] = $this->share(function($c) {
            $namespaceToPath = str_replace('\\', DIRECTORY_SEPARATOR, $c['namespace']);
            return sprintf('%s%sconfig%scommands.yml', $c['root_dir'], DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
        });

        $this['fs']              = new Filesystem();

        $this->initialize();
        $this->injectValues($default);
    }
    
    /**
     * @param array $values
     */
    private function injectValues(array $values = array())
    {
        foreach ($values as $key => $value)
        {
            $this[$key] = $value;
        }
    }

    /**
     * Hook
     */
    protected function initialize()
    {

    }

}
