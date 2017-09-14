<?php

namespace Novosti\Services\Parser\Impl;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Parser\AbstractMediaParser;
use Novosti\Model\News;
use Goutte\Client;

class KlixMediaParser extends AbstractMediaParser
{

    private const SITEMAP_ENDPOINT = 'https://www.klix.ba/sitemap/news';

    private const HTML_ENDPOINT = 'https://www.klix.ba/najnovije';

    private $client;

    function __construct()
    {
        $this->client = new Client;
    }

    public function parse()
    {
        $crawl = $this->client->request('GET', self::HTML_ENDPOINT);

        $crawl->filter('article.kartica.srednja')->each(function($node) {
            $this->article = new News; 
            $this->article->comment = $node->filter('span')->text();
            $this->article->subject = $node->filter('h1')->text();
            $this->article->url     = $node->filter('a')->link()->getUri();
        });

        $this->save($this->article);
    }

}
