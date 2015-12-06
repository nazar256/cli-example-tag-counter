<?php

namespace IO;

use IO\Interfaces\OutputInterface;

class TerminalOutput implements OutputInterface
{
    private $outputHandler;

    public function __construct()
    {
        $this->outputHandler = STDOUT;
    }

    public function writeln($outputString)
    {
        $this->write($outputString);
        fwrite($this->outputHandler, "\n");
    }

    public function write($outputString)
    {
        fwrite($this->outputHandler, $outputString);
    }
}