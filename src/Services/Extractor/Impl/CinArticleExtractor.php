<?php

namespace Novosti\Services\Extractor\Impl;

use Novosti\Services\Extractor\BaseArticleExtractor;
use Novosti\Command\CinParseCommand;
use Novosti\Model\Post;

class CinArticleExtractor extends BaseArticleExtractor
{

    /**
     * @var $client
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

    /**
     * @const attr
     */
    const PORTAL = CinParseCommand::PORTAL;

    function __construct($url, $hash)
    {
        parent::__construct();

        $this->url = $url;
        $this->hash = $hash;
    }
/**
     * @const PORTAL
     */
    public function getPortal()
    {
        return self::PORTAL;
    }

    function extract()
    {
        $this->logger->write()->info(sprintf("Requesting article with URL: %s", $this->url));
        $crawl = $this->client->request('GET', $this->url);

        $this->post = new Post;
        $this->post->title = $crawl->filter('h1').text();
    }

}
