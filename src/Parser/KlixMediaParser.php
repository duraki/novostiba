<?php

namespace Novosti\Parser;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class KlixMediaParser extends AbstractMediaParser
{

    private const API_ENDPOINT = 'https://www.klix.ba/sitemap/news';

    private function extract()
    {

    }

}
