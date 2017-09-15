<?php

namespace Novosti\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Parser\Impl\KlixMediaParser;

final class KlixParseCommand extends BaseCommand 
{

    public const PORTAL = 'novosti.portal.klix.ba';

    protected function configure()
    {
        $this->setName('novosti:parse:klix');
        $this->setDescription('Parses and analyze latest news from Klix.ba.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($output);

        $this->logger->write()->info(sprintf("Creating parser object for %s ...", $this->getPortal()));

        $this->parser = new KlixMediaParser;
        $this->parser->parse();

        return 0;
    }

    function getPortal()
    {
        return self::PORTAL;
    }


}
