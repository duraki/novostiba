<?php

namespace Novosti\Command\Feed;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Novosti\Common\Logger;
use Novosti\Services\Feed\CreateFeedService;

class CreateFeedCommand extends Command
{

    const COMMAND_ARTICLE_LOG_HANDLER = 'feed';

    /**
     * @var $logger
     */
    protected $logger;

    private $feed;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->logger = new Logger(self::COMMAND_ARTICLE_LOG_HANDLER);
        $this->feed = new CreateFeedService;
    }

    protected function configure()
    {
        $this->setName('novosti:feed:create');
        $this->setDescription('Create and generate feed for latest news.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->feed->createFeed();        
    }

}
