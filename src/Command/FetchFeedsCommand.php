<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\FeedPost;
use App\Service\FeedParserService;

class FetchFeedsCommand extends Command
{
    protected static $defaultName = 'app:fetch-feeds';

    function __construct(EntityManagerInterface $em, FeedParserService $feedParserService) {
        $this->em = $em;
        $this->feedParserService = $feedParserService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetches and persist new feed posts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->feedParserService->parseAllFeeds($output);

        return 0;
    }
}
