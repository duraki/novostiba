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
    
        $articles = $this->repository->getArticles(); # previous results (def: 10 past)
        $url = []; # dataset for currently found urls

        foreach ($this->article as $newArticle) {
            $urls[] = $newArticle->url;
        }

    


        $this->repository->saveArticle($article);
    }

}
