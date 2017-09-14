<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{

    protected function start($output, $portal)
    {
        $output->writeln(sprintf(
            'Analyzing and parsing news from: %s', $portal 
        ));
    }

}
