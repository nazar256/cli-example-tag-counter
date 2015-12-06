<?php

namespace IO\Interfaces;

interface OutputInterface
{
    public function write($outputString);

    public function writeln($outputString);
}