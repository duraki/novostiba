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
        parent::__construct();
    }

    public function getArticles($service = '', $count = 30)
    {
        return $this->conn->select('articles', 'url', [
            'LIMIT' => $count,
            'ORDER' => [
                'rowid' => "DESC"
            ],
            'service' => $service
        ]);
    }

    public function getAllArticles($count = 30)
    {
        return $this->conn->select('articles', ['url', 'subject'], [
            'LIMIT' => $count,
            'ORDER' => [
                'rowid' => "DESC"
            ],
        ]);
    }

    public function saveArticle(News $news)
    {
        $this->conn->insert('articles', [
            'comment' => $news->comment,
            'subject' => $news->subject,
            'url' => $news->url,
            'service' => $news->service,
            'id' => $news->id,
        ]);
    }

}
