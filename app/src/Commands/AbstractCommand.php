<?php

namespace Commands;

use IO\Interfaces\InputInterface;
use IO\Interfaces\OutputInterface;

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

    private $startTime;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->startTime = microtime(true);
    }

    protected function getStartTime()
    {
        return $this->startTime;
    }

    public abstract function execute();
}