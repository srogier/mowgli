<?php

namespace sro\Mowgli\Logger;

use \Symfony\Component\Console\Helper\FormatterHelper;
use \Symfony\Component\Console\Output\OutputInterface;

class OutputLogger implements LoggerInterface
{
    /**
     * @var FormatterHelper;
     */
    private $formatterHelper;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Symfony\Component\Console\Helper\FormatterHelper $formatterHelper
     */
    public function __construct(OutputInterface $output, FormatterHelper $formatterHelper)
    {
        $this
            ->setOutput($output)
            ->setFormatterHelper($formatterHelper);
    }

    /**
     * @param        $message
     * @param string $level
     */
    public function log($message, $level = 'info')
    {
        $this->getOutput()->writeln($this->getFormatterHelper()->formatBlock($message, $level));
    }

    /**
     *
     * @return \Symfony\Component\Console\Helper\FormatterHelper
     */
    public function getFormatterHelper()
    {
        return $this->formatterHelper;
    }

    /**
     *
     * @param \Symfony\Component\Console\Helper\FormatterHelper $formatterHelper
     *
     * @return \sro\Mowgli\Logger\OutputLogger
     */
    public function setFormatterHelper(FormatterHelper $formatterHelper)
    {
        $this->formatterHelper = $formatterHelper;

        return $this;
    }

    /**
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \sro\Mowgli\Logger\OutputLogger
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }
}
