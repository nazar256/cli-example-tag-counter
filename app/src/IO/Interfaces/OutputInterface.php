<?php

namespace IO\Interfaces;

/**
 * Interface of output object to write strings somewhere
 */
interface OutputInterface
{
    /**
     * @param string $outputString
     */
    public function write($outputString);

    /**
     * @param string $outputString
     */
    public function writeln($outputString);
}