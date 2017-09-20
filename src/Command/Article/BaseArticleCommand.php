<?php

namespace Novosti\Command\Article;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Extractor\Impl\KlixArticleExtractor;
use Novosti\Services\Extractor\Impl\CinArticleExtractor;
use Novosti\Repository\Impl\PostRepository;
use Novosti\Repository\Impl\NewsRepository;
use Novosti\Model\Post;
use Novosti\Command\KlixParseCommand;
use Novosti\Command\CinParseCommand;
use Novosti\Common\Logger;

class BaseArticleCommand extends Command
{

    const COMMAND_ARTICLE_LOG_HANDLER = 'command';

    private $media = [
        1 => [ 
            KlixParseCommand::PORTAL,
            KlixArticleExtractor::class, 
        ],

        2 => [
            CinParseCommand::PORTAL,
            CinArticleExtractor::class,
        ],
    ];

    /**
     * @var $postsRepository
     */
    private $postRepository;

    /**
     * @var $newsRepository
     */
    private $newsRepository;

    /**
     * @var $logger
     */
    protected $logger;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->logger = new Logger(self::COMMAND_ARTICLE_LOG_HANDLER);
        $this->postRepository = new PostRepository;
        $this->newsRepository = new NewsRepository;
    }

    protected function configure()
    {
        $this->setName('novosti:article:extract');
        $this->setDescription('Extract news from all services');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->write()->info("Execution of base article|post extraction");

        // % @var $cmd eq `novosti.portal.*`
        foreach ($this->media as $cmd) {
            $news = $this->getNewsByMedia($cmd[1]);
            $posts = $this->getPostsByMedia($cmd[1]);
        }

        $new = array_diff($news, $posts); // returns all from $1 that are not present in $2

        $this->logger->write()->info(sprintf("Total new articles to extract: %s! Do it!", count($new)));

        foreach ($this->media as $em) {
            $this->logger->write()->info(sprintf("Extracting with object: %s", json_encode($em)));
            $this->getArticlesByMedia($em[0], $new);
        }
    }

    private function getArticlesByMedia($media, $new)
    {
        foreach ($new as $url) {
            $id = $this->newsRepository->getHashByUrl($url);
            $id = $id[0]['hash'];

            $extractArticle = new $media($url, $id);
            $extractArticle->extract();
        }
    }

    private function getNewsByMedia($service)
    {
        return $this->newsRepository->getArticles($service);
    }

    private function getPostsByMedia($service)
    {
        return $this->postRepository->getPosts($service);
    }

}
