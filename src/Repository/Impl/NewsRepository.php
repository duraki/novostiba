<?php

namespace Novosti\Repository\Impl;

use Novosti\Repository\Common\CommonRepository;
use Novosti\Model\News;
use Medoo\Medoo;

class NewsRepository extends CommonRepository
{

    function __construct()
    {
        //
    }

    public function getArticles($service = '', $count = 10)
    {
        return $this->conn->select('articles', 'url', [
            'LIMIT' => $count,
        ]);
    }

    public function saveArticle(News $news)
    {
        $this->conn->insert('articles', [
            'comment' => $news->comment,
            'subject' => $news->subject,
            'url' => $news->url,
            'service' => $news->service,
        ]);
    }

}
