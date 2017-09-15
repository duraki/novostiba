<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Parser\Impl\CinMediaParser;

final class CinParseCommand extends BaseCommand 
{

    public const PORTAL = 'novosti.portal.cin.ba';

    protected function configure()
    {
        $this->setName('novosti:parse:cin');
        $this->setDescription('Parses and analyze latest news from Cin.ba.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($output);

        $this->logger->write()->info(sprintf("Creating parser object for %s ...", $this->getPortal()));

        $this->parser = new CinMediaParser;
        $this->parser->parse();

        return 0;
    }

    function getPortal()
    {
        return self::PORTAL;
    }


}
