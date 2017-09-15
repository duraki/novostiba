<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Common\Logger;

abstract class BaseCommand extends Command
{

    const COMMAND_LOG_HANDLER = 'command';

    /**
     * @var $logger
     */
    protected $logger;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->logger = new Logger(self::COMMAND_LOG_HANDLER); 
    }

    protected function start($output)
    {
        $this->logger->write()->info(sprintf("Started base command: %s", $this->getPortal()));
        $output->writeln(sprintf(
            'Analyzing and parsing news from: %s', $this->getPortal() 
        ));
    }

}
