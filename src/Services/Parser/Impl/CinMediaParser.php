<?php

namespace Novosti\Services\Parser\Impl;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Parser\AbstractMediaParser;
use Novosti\Command\CinParseCommand;
use Novosti\Model\News;
use Goutte\Client;

class CinMediaParser extends AbstractMediaParser
{

    private const HTML_ENDPOINT = 'https://www.cin.ba/category/vijesti/';

    private $client;

    function __construct()
    {
        parent::__construct();

        $this->logger->write()->info("Creating client interface");
        $this->client = new Client;
    }


    public function parse()
    {
        $this->logger->write()->info(sprintf("Requesting website with endpoint: %s", self::HTML_ENDPOINT));
        $crawl = $this->client->request('GET', self::HTML_ENDPOINT);

        $this->logger->write()->info("Starting node selection and data extraction ...");
        $crawl->filter('.vijesti-box')->each(function($node) {

            $this->logger->write()->info("Moving dataset into model group ...");

            $this->article = new News; 
            $this->article->comment = 'NONE'; 
            $this->article->subject = $node->filter('div.vijesti-naslov')->text();
            $this->article->url     = $node->filter('a')->link()->getUri();
            $this->article->service = CinParseCommand::PORTAL;
            $this->article->id      = "CIN".$node->filter('div.vijesti-share')->text();
            $this->article->hash    = $this->random();

            $this->logger->write()->info(sprintf("Found #{ID}: %s | #{Service}: %s", $this->article->id, $this->article->service));

            $this->save($this->article);
        });

    }

}
