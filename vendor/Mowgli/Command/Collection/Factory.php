<?php

namespace Mowgli\Command\Collection;

use Symfony\Component\Yaml\Yaml;

class Factory
{

    /**
     * @param $ymlFilePath
     *
     * @return Collection
     * @throws \InvalidArgumentException|\RuntimeException
     */
    public function buildFromYml($ymlFilePath)
    {
        if (!is_readable($ymlFilePath))
        {
            throw new \InvalidArgumentException(sprintf('Unable to read %s', $ymlFilePath));
        }

        $commands = Yaml::parse($ymlFilePath);

        if (!isset($commands['commands']))
        {
            throw new \RuntimeException(sprintf('Invalid format : the key {commands} is required in file %s', $ymlFilePath));
        }

        $collection = new Collection();
        foreach ($commands['commands'] as $command)
        {
            $collection->registerCommand(new $command());
        }

        return $collection;
    }
}
