<?php

namespace Commands;

use IO\Interfaces\InputInterface;
use IO\Interfaces\OutputInterface;

/**
 * Contains common methods for possible commands
 */
abstract class AbstractCommand
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Must be private as it's not meant to be changed in child classes
     * @var float
     */
    private $startTime;

    /**
     * AbstractCommand constructor.
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->startTime = microtime(true);
    }

    /**
     * @return float
     */
    protected function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Main method for commands
     */
    public abstract function execute();
}