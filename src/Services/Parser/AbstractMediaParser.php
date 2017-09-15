<?php

namespace Novosti\Services\Parser;

use Novosti\Model\News;
use Novosti\Repository\Impl\NewsRepository;
use Novosti\Common\Logger;

abstract class AbstractMediaParser
{

    /**
     * @var $parser
     */
    protected $parser;

    /**
     * @var $article
     */
    protected $article;

    /**
     * @var $repository
     */
    private $repository;

    /**
     * @var $logger
     */
    protected $logger;

    const PARSER_LOG_HANDLER = 'parser'; 

    function __construct()
    {
        $this->logger = new Logger(self::PARSER_LOG_HANDLER);
    }

    private function isUrlInDatabase(array $results, $url)
    {
        foreach ($results as $db) {
            if ($db == $url) {
                $this->logger->write()->info("Found URL already in the database.");
                return true;
            }
        }

        return false;
    }

    protected function save(News $article)
    {
        $this->repository = new NewsRepository;
    
        $pastNews = $this->repository->getArticles($article->service); # previous results, limit: 10 
        $current = $article->url; # dataset for currently found url

        $this->logger->write()->info(sprintf("Got %d past results!", count($pastNews)));

        $this->logger->write()->info("Checking if article is in database ...");

        if ($this->isUrlInDatabase($pastNews, $current)) {
            $this->logger
                ->write()
                ->warning(sprintf("Article seems to be in the database, skipping!", count($pastNews)));
            return true;
        }

        $this->logger->write()->info("Article not found, saving new one ...");
        $this->repository->saveArticle($article);
    }

    abstract public function parse();
}
