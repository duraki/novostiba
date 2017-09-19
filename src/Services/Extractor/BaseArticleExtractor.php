<?php

namespace Novosti\Services\Extractor;

use Novosti\Model\Post;
use Novosti\Repository\Impl\PostRepository;
use Novosti\Services\Feed\CreatePostService as Feed;
use Novosti\Common\Logger;
use Goutte\Client;

abstract class BaseArticleExtractor
{

    /**
     * @var $logger
     */
    protected $logger;

    /**
     * @var client
     */
    protected $client;

    /**
     * @var $post
     */
    protected $post;

    /**
     * @var $repository
     */
    protected $repository;

    /**
     * @var feed
     */
    private $feed;	

    const EXTRACTOR_LOG_HANDLER = 'extractor';

    function __construct()
    {
        $this->logger = new Logger(self::EXTRACTOR_LOG_HANDLER);
        $this->repository = new PostRepository;
        $this->feed = new Feed;

        $this->logger->write()->info(sprintf("Creating client interface ... %s",
            $this->getPortal()));

        $this->client = new Client;
    }

    protected function save(Post $post)
    {
        $this->logger->write()->info("Saving article post data ...");
        $this->repository->savePost($post);
        $this->logger->write()->info("Post saved!");

        $this->logger->write()->info("Generating new feed for this post ...!");
        $this->feed->createPost($post);
        $this->logger->write()->info("Feed generated; static HTML output created. I'm a good bot :)");
    }

    abstract public function extract();

}
