<?php

namespace Novosti\Repository\Impl;

use Novosti\Repository\Common\CommonRepository;
use Novosti\Model\Post;

class PostRepository extends CommonRepository
{

    function __construct()
    {
        parent::__construct();
    }

    public function getPosts($service = '', $count = 30)
    {
        return $this->conn->select('posts', 'url', [
            'LIMIT' => $count,
            'ORDER' => [
                'rowid' => "DESC"
            ],
            'service' => $service
        ]);
    }

    public function getAllPosts($count = 30)
    {
        return $this->conn->select('posts', ['rowid', 'url', 'id'], [
            'LIMIT' => $count,
            'ORDER' => [
                'rowid' => 'DESC'
            ],
        ]);
    }

    public function savePost(Post $post)
    {
        $this->conn->insert('posts', [
            'title' => $post->title,
            'comment' => $post->comment,
            'text' => $post->text,
            'tags' => $post->tags,
            'service' => $post->service,
            'url' => $post->url,
            'hash' => $post->hash
        ]);
    }

}
