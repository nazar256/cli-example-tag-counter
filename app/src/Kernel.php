<?php
use Commands\AbstractCommand;
use IO\Input;
use IO\Interfaces\InputInterface;
use IO\Interfaces\OutputInterface;
use IO\TerminalOutput;

/**
 * Main Application class
 */
class Kernel
{
    const ARG_IDX_COMMAND   = 0;
    const COMMAND_NAMESPACE = 'Commands';

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * initializes application
     * @return $this
     */
    public function boot()
    {
        global $argv;
        $scriptArguments = array_slice($argv, 1);
        $this->input = new Input($scriptArguments);
        $this->output = new TerminalOutput();

        return $this;
    }

    /**
     * Selects and executes appropriate command
     */
    public function executeCommand()
    {
        try {
            $command = $this->instantiateCommand();
            $command->execute();
        } catch (Exception $exception) {
            $this->output->writeln($exception->getMessage());
        }
    }

    /**
     * @return AbstractCommand
     */
    private function instantiateCommand()
    {
        global $registeredCommands;
        $commandName = $this->input->getArgument(self::ARG_IDX_COMMAND);
        if (!$commandName) {
            throw new InvalidArgumentException('Command was not specified');
        }
        $commandClassName = self::COMMAND_NAMESPACE . '\\' . $commandName . 'Command';
        if (!in_array($commandName, $registeredCommands)) {
            throw new InvalidArgumentException(sprintf('Command %s does not exist', $commandName));
        }

        return new $commandClassName($this->input, $this->output);
    }
}