<?php

namespace IO\Interfaces;

/**
 * Interface of input object to get passed arguments
 */
interface InputInterface
{
    /**
     * @param int $argumentIndex
     * @return mixed
     */
    public function getArgument($argumentIndex);
}