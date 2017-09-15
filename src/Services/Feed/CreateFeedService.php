<?php

namespace Novosti\Services\Feed;

use Novosti\Repository\Impl\NewsRepository;
use Novosti\Common\Writer;

class CreateFeedService
{

    /**
     * @var $writer
     */
    private $writer;

    const FEED_FILE = __DIR__.'/../../../docs/index.html';

    public function createFeed($limit = 30)
    {
        $news = new NewsRepository;         

        $news = $news->getAllArticles();

        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../../../views');
        $twig = $twig = new \Twig_Environment($loader);

        $feed = $twig->render('home.twig', array('news' => $news));

        Writer::writeDataToFile($feed, self::FEED_FILE); 
    }


}
