<?php

namespace Novosti\Services\Parser\Impl;

use Novosti\Services\Parser\AbstractMediaParser;
use Novosti\Command\KlixParseCommand;
use Novosti\Model\News;
use Goutte\Client;

class KlixMediaParser extends AbstractMediaParser
{

    private const SITEMAP_ENDPOINT = 'https://www.klix.ba/sitemap/news';

    private const HTML_ENDPOINT = 'https://www.klix.ba/najnovije';

    /**
     * @var $client;
     */
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
        $crawl->filter('article.kartica.srednja')->each(function($node) {

            $this->logger->write()->info("Moving dataset into model group ...");

            $this->article = new News; 
            $this->article->comment = $node->filter('span')->text();
            $this->article->subject = $node->filter('h1')->text();
            $this->article->url     = $node->filter('a')->link()->getUri();
            $this->article->service = KlixParseCommand::PORTAL;
            $this->article->id      = strtoupper(
                                      str_replace(' ', '_', $this->article->comment));

            $this->logger->write()->info(sprintf("Found #{ID}: %s | #{Service}: %s", $this->article->id, $this->article->service));

            $this->save($this->article);
        });

        return true;
    }

}
