<?php

namespace sro\Mowgli\Validator;

class Validators
{
    static public function validateProjectName($name)
    {
        if(!preg_match('/([a-zA-Z1-9-_]+)/', $name))
        {
            throw new \InvalidArgumentException('The project name contains invalid character');
        }

        return $name;
    }

    /**
     * @static
     *
     * @param string $namespace
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    static public function validateNamespace($namespace)
    {
        $namespace = strtr($namespace, '/', '\\');
        if (!preg_match('/^(?:[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\\\?)+$/', $namespace))
        {
            throw new \InvalidArgumentException('The namespace contains invalid characters.');
        }

        // validate reserved keywords
        $reserved = self::getReservedWords();
        foreach (explode('\\', $namespace) as $word)
        {
            if (in_array(strtolower($word), $reserved))
            {
                throw new \InvalidArgumentException(sprintf('The namespace cannot contain PHP reserved words ("%s").', $word));
            }
        }

        return $namespace;
    }

    /**
     * @static
     *
     * @param string $dir
     *
     * @return string
     */
    static public function validateTargetDir($dir)
    {
        // add trailing / if necessary
        return '/' === substr($dir, -1, 1) ? $dir : $dir . '/';
    }

    /**
     * @static
     * @return array
     */
    static private function getReservedWords()
    {
        return array(
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'do',
            'else',
            'elseif',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'extends',
            'final',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'interface',
            'instanceof',
            'namespace',
            'new',
            'or',
            'private',
            'protected',
            'public',
            'static',
            'switch',
            'throw',
            'try',
            'use',
            'var',
            'while',
            'xor',
            '__CLASS__',
            '__DIR__',
            '__FILE__',
            '__LINE__',
            '__FUNCTION__',
            '__METHOD__',
            '__NAMESPACE__',
            'die',
            'echo',
            'empty',
            'exit',
            'eval',
            'include',
            'include_once',
            'isset',
            'list',
            'require',
            'require_once',
            'return',
            'print',
            'unset',
        );
    }

}
