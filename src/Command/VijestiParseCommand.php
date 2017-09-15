<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Parser\Impl\VijestiMediaParser;

final class VijestiParseCommand extends BaseCommand 
{

    public const PORTAL = 'novosti.portal.vijesti.ba';

    protected function configure()
    {
        $this->setName('novosti:parse:vijesti');
        $this->setDescription('Parses and analyze latest news from Vijesti.ba.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($output);

        $this->logger->write()->info(sprintf("Creating parser object for %s ...", $this->getPortal()));

        $this->parser = new VijestiMediaParser;
        $this->parser->parse();

        return 0;
    }

    function getPortal()
    {
        return self::PORTAL;
    }


}
