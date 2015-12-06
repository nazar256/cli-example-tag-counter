<?php

namespace IO;

use IO\Interfaces\InputInterface;

/**
 * Console input object
 */
class Input implements InputInterface
{
    /**
     * contains command line arguments
     * @var string[]
     */
    private $arguments = [];

    /**
     * Input constructor.
     * @param string[] $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param int $argumentIndex
     * @return null|string
     */
    public function getArgument($argumentIndex)
    {
        $indexExists = array_key_exists($argumentIndex, $this->arguments);
        $argumentValue = $indexExists ? $this->arguments[$argumentIndex] : null;

        return $argumentValue;
    }
}