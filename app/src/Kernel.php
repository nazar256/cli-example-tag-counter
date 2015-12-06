<?php
use IO\Input;
use IO\TerminalOutput;
use Commands\AbstractCommand;
use IO\Interfaces\InputInterface;
use IO\Interfaces\OutputInterface;

class Kernel
{
    const ARG_IDX_COMMAND = 0;
    const COMMAND_NAMESPACE = 'Commands';

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    public function boot()
    {
        global $argv;
        $scriptArguments = array_slice($argv, 1);
        $this->input = new Input($scriptArguments);
        $this->output = new TerminalOutput();

        return $this;
    }

    public function executeCommand()
    {
        try{
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
        if(!$commandName) {
            throw new InvalidArgumentException('Command was not specified');
        }
        $commandClassName = self::COMMAND_NAMESPACE. '\\'. $commandName. 'Command';
        if(!in_array($commandName, $registeredCommands)){
            throw new InvalidArgumentException(sprintf('Command %s does not exist', $commandName));
        }

        return new $commandClassName($this->input, $this->output);
    }
}