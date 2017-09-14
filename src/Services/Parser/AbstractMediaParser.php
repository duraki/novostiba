<?php

namespace Novosti\Services\Parser;

use Novosti\Model\News;

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

    protected function save(News $article)
    {
        $article->save();
    }

}
