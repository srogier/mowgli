<?php

namespace sro\Mowgli\Command;

use Mowgli\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;

class Compile extends Command
{

    protected function configure()
    {
        $this
            ->setName('compile')
            ->setDescription('Creates a distribuable PHAR archive based on your project')
            ->setDefinition(array(
                                 new InputArgument('archive_base_name', InputArgument::OPTIONAL, 'The parameter name'),
                                 new InputOption('force', null, InputOption::VALUE_NONE, 'Remove existing archive'),
                            ))
            ->setHelp(<<<EOF
The <info>compile</info> command creates a distribuable PHAR archive based on your project:

    <info>mowgli compile</info>
   
You can set the base name of your PHAR archive by using the <comment>archive_base_name</comment> argument:

    <info>mowgli compile foo</info> will create an archive named <comment>foo.php</comment>
    
You can also output the list of file added into your PHAR archive by using the <comment>--verbose</comment> option:

    <info>mowgli compile --verbose</info>
         
If PHAR archive already exists, this command will return an error. You can remove the archive by using the <comment>--force</comment> option:

    <info>mowgli compile --force</info>
EOF
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $verbose   = $input->getOption('verbose');

        $archiveName = $this->buildArchiveName($input);
        $pharPath    = $this->buildPharPath($input, $archiveName);

        if ($verbose)
        {
            $output->writeln(sprintf('Packaging files in %s', $container['root_dir']));
        }

        $phar = new \Phar($pharPath, \Phar::PHAR);
        $phar->buildFromIterator($this->getFiles($container['root_dir']), $container['root_dir']);
        $phar->setStub($this->getPharStub($archiveName));

        $output->writeln(sprintf('%s has been compiled in %s', $this->getApplication()->getName(), $pharPath));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function buildArchiveName(InputInterface $input)
    {
        if (null === $archiveBaseName = $input->getArgument('archive_base_name'))
        {
            $archiveBaseName = strtolower($this->getApplication()->getName());
        }
        return sprintf('%s.phar', $archiveBaseName);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param                                                 $archiveName
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function buildPharPath(InputInterface $input, $archiveName)
    {
        /** @var $fs \Symfony\Component\Filesystem\Filesystem */
        $container = $this->getContainer();
        $fs        = $container['fs'];
        $server    = $this->getServerHelper();

        $pharPath = $server->getPwd() . '/' . $archiveName;

        if (file_exists($pharPath))
        {
            if ($input->getOption('force'))
            {
                $fs->remove($pharPath);
            }
            else
            {
                throw new \RuntimeException(sprintf('The file %s already exists', $pharPath));
            }
        }

        return $pharPath;
    }

    /**
     * @param $archiveName
     *
     * @return string
     */
    protected function getPharStub($archiveName)
    {
        return "<?php
\$archiveName = 'phar://" . $archiveName . "';
require_once \$archiveName . '/src/autoload.php';

use sro\Mowgli\Application;
use sro\Mowgli\Container\Container;

\$application = new Application(new Container(array('root_dir' => \$archiveName)));
\$application->run(); __HALT_COMPILER(); ?>";
    }


    /**
     * @param $rootDir
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function getFiles($rootDir)
    {
        $finder = new Finder();
        return $finder
            ->files()
            ->ignoreVCS(true)
            ->exclude('.idea')
            ->in($rootDir);
    }


}
