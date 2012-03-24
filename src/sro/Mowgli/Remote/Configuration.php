<?php

namespace sro\Mowgli\Remote;

use \Symfony\Component\Process\Process;

class Configuration
{

    /**
     * @const string
     */
    const MOWGLI_FLAG = '.mowgli';

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->setRootDir($rootDir);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        $moglyFlagFile = $this->getRootDir() . DIRECTORY_SEPARATOR . self::MOWGLI_FLAG;
        if (!is_file($moglyFlagFile))
        {
            throw new \RuntimeException(sprintf(
                'Mogly Flag File [%s] not found',
                $moglyFlagFile
            ));
        }
        $executable   = trim(file_get_contents($moglyFlagFile));
        $cmd = sprintf(
            '%s config %s',
            escapeshellarg($executable),
            escapeshellarg($key)
        );

        $process = $this->getProcess($cmd);

        $process->run();
        
        if (!$process->isSuccessful())
        {
            throw new \InvalidArgumentException(sprintf(
                "Can't retrieve argument [%s] in project %s ",
                $key,
                $this->getRootDir()
            ));
        }
        
        return trim($process->getOutput()); 
    }

    /**
     * @param string $rootDir
     *
     * @throws \InvalidArgumentException
     */
    private function checkRootDir($rootDir)
    {
        if (!is_readable(sprintf('%s/%s', $rootDir, self::MOWGLI_FLAG)))
        {
            throw new \InvalidArgumentException(sprintf('There is no Mowgli project in %s', $rootDir));
        }
    }

    /**
     * @param $commandLine
     * @return \Symfony\Component\Process\Process
     */
    private function getProcess($commandLine)
    {
        return new Process($commandLine);
    }

    /**
     *
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @param string $rootDir
     *
     * @return \sro\Mowgli\Remote\Configuration
     */
    public function setRootDir($rootDir)
    {
        $this->checkRootDir($rootDir);
        $this->rootDir = $rootDir;

        return $this;
    }

}
