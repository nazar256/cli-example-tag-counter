<?php

namespace IO;

use IO\Interfaces\InputInterface;

class Input implements InputInterface
{
    private $arguments = [];

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArgument($argumentIndex)
    {
        $indexExists = array_key_exists($argumentIndex, $this->arguments);
        $argumentValue = $indexExists ? $this->arguments[$argumentIndex] : null;

        return $argumentValue;
    }
}