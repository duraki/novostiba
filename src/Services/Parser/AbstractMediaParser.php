<?php

namespace Novosti\Services\Parser;

use Novosti\Model\News;
use Novosti\Repository\Impl\NewsRepository;

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

    protected function save(News $article)
    {
        $this->repository = new NewsRepository;
        $this->repository->saveArticle($article);
    }

}
