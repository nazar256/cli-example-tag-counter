<?php

namespace IO;

use IO\Interfaces\OutputInterface;

/**
 * STDOUT output object
 */
class TerminalOutput implements OutputInterface
{
    private $outputHandler;

    /**
     * TerminalOutput constructor.
     */
    public function __construct()
    {
        $this->outputHandler = STDOUT;
    }

    /**
     * @param string $outputString
     */
    public function writeln($outputString)
    {
        $this->write($outputString);
        fwrite($this->outputHandler, "\n");
    }

    /**
     * @param string $outputString
     */
    public function write($outputString)
    {
        fwrite($this->outputHandler, $outputString);
    }
}