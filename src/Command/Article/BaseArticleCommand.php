<?php

namespace Novosti\Command\Article;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Services\Extractor\Impl\KlixArticleExtractor;
use Novosti\Repository\Impl\PostRepository;
use Novosti\Repository\Impl\NewsRepository;
use Novosti\Model\Post;
use Novosti\Command\KlixParseCommand;
use Novosti\Common\Logger;

class BaseArticleCommand extends Command
{

    const COMMAND_ARTICLE_LOG_HANDLER = 'command';

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

        //xxx: call from arr[]::PORTAL 
        $news = $this->getNewsByMedia(KlixParseCommand::PORTAL);
        $posts = $this->getPostsByMedia(KlixParseCommand::PORTAL);

        $new = array_diff($news, $posts); // returns all from $1 that arent present in $2

        foreach ($new as $url) {
            $ids = $this->newsRepository->getHashByUrl($url);

            $klix = new KlixArticleExtractor($url, $ids[0]['hash']);
            $klix->extract();
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
