<?php

namespace Novosti\Services\Extractor\Impl;

use Novosti\Services\Extractor\BaseArticleExtractor;
use Novosti\Command\KlixParseCommand;
use Novosti\Model\Post;

class KlixArticleExtractor extends BaseArticleExtractor
{

    /**
     * @var $client;
     */
    protected $client;

    /**
     * @var $url
     */
    private $url;

    /**
     * @var $hash
     */
    private $hash;

    function __construct($url, $hash)
    {
        parent::__construct();

        $this->url = $url;
        $this->hash = $hash;
    }

    function extract()
    {
        $this->logger->write()->info(sprintf("Requesting article with URL: %s", $this->url));
        $crawl = $this->client->request('GET', $this->url);

        $this->logger->write()->info("Starting article data extraction ...");

        $this->post = new Post;
        $this->post->title = $crawl->filter('div.naslov > h1')->text();
        $this->post->comment = $crawl->filter('div.articleCategory > span')->text();

        $this->post->text = 
            $crawl->filter('div.uvod')->text()."\n\n\n".
            $crawl->filter('div.tekst')->text();

        $this->post->tags = $crawl->filter('div.clanakTagovi > a')->text();
        $this->post->service = KlixParseCommand::PORTAL;
        $this->post->url = $this->url;
        $this->post->hash = $this->hash;

        $this->logger->write()->info(sprintf("DATA: %s ;saving", json_encode($this->post)));

        $this->save($this->post); 
    }


}
