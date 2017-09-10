<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class KlixParseCommand extends Command
{

    private const PORTAL = 'https://klix.ba';

    protected function configure()
    {
        $this->setName('media:parse:klix');
        $this->setDescription('Parses and analyze latest news from Klix.ba.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(sprintf(
            'Analyzing and parsing news from: %s', self::PORTAL
        ));

        return 0;
    }


}
