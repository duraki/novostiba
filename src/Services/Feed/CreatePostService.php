<?php

namespace Novosti\Services\Feed;

use Novosti\Repository\Impl\PostRepository;
use Novosti\Common\Writer;
use Novosti\Model\Post;

class CreatePostService
{

    /**
     * @var $repository
     */
    private $repository;

    const POST_FILE = __DIR__.'/../../../docs/vijesti';

    function __construct()
    {
        $this->repository = new PostRepository;
    }

    public function createPost(Post $post)
    {
        $loader = new \Twig_Loader_Filesystem(getenv('VIEWS'));
        $twig = new \Twig_Environment($loader);

        $bind = $twig->render('post.twig', array('post' => $post));

        Writer::writeDataToFile($bind, self::POST_FILE."/".$post->hash.".html");
    }
}
