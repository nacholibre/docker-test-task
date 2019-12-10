<?php

namespace App\Service;

use App\Entity\FeedPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class FeedParserService {
    const INSERT_BATCH_COUNT = 20;

    function __construct(EntityManagerInterface $em, \Predis\Client $redis, KernelInterface $kernel) {
        $this->em = $em;
        $this->redis = $redis;
        $this->kernel = $kernel;
    }

    public function parseFeed($jsonData, $feedType) {
        switch($feedType) {
            case FeedPost::FEED_TYPE_A:
                $parser = new Parsers\FeedAParser;

                break;
            case FeedPost::FEED_TYPE_B:
                $parser = new Parsers\FeedBParser;

                break;
            case FeedPost::FEED_TYPE_C:
                $parser = new Parsers\FeedCParser;

                break;
            default:
                throw \Exception('No such feed');
        }

        $arrayData = json_decode($jsonData, true);

        return array_map(function($row) use ($parser) {
            return $parser->parsePost($row);
        }, $arrayData);
    }

    public function parseAllFeeds($output=null) {
        $rootDir = $this->kernel->getProjectDir();

        $feedsLocation = [
            [
                'type' => FeedPost::FEED_TYPE_A,
                'location' => $rootDir . '/resources/feed_a.json',
            ],
            [
                'type' => FeedPost::FEED_TYPE_B,
                'location' => $rootDir . '/resources/feed_b.json',
            ],
            [
                'type' => FeedPost::FEED_TYPE_C,
                'location' => $rootDir . '/resources/feed_C.json',
            ],
        ];

        if ($output) {
            $output->writeln('Start parsing feeds');
        }

        foreach($feedsLocation as $feedData) {
            if ($output) {
                $output->writeln("Start feed {$feedData['location']}");
            }

            $fetchedData = file_get_contents($feedData['location']);
            $parsedPosts = $this->parseFeed($fetchedData, $feedData['type']);
            $insertedCount = $this->insertFeedsIfNew($parsedPosts);

            $postsFound = count($parsedPosts);

            if ($output) {
                $output->writeln("Posts found {$postsFound}");
                $output->writeln("Inserted posts {$insertedCount}");
                $output->writeln('=================================');
            }
        }
    }

    public function insertFeedsIfNew(array $feedPosts) {
        $feedPostALast = $this->em->getRepository('App:FeedPost')->findOneBy(['type' => FeedPost::FEED_TYPE_A], ['id' => 'DESC']);
        $feedPostBLast = $this->em->getRepository('App:FeedPost')->findOneBy(['type' => FeedPost::FEED_TYPE_B], ['id' => 'DESC']);
        $feedPostCLast = $this->em->getRepository('App:FeedPost')->findOneBy(['type' => FeedPost::FEED_TYPE_C], ['id' => 'DESC']);

        $feedPostsLastByType = [
            FeedPost::FEED_TYPE_A => $feedPostALast,
            FeedPost::FEED_TYPE_B => $feedPostBLast,
            FeedPost::FEED_TYPE_C => $feedPostCLast,
        ];

        $insertedPosts = 0;
        $i = 0;
        foreach($feedPosts as $feedPost) {
            $insert = (  $feedPostsLastByType[$feedPost->getType()] == null or ($feedPost->getDateCreated() > $feedPostsLastByType[$feedPost->getType()]->getDateCreated())  );

            if ($insert) {
                $feed = new FeedPost;
                $feed->setType($feedPost->getType());
                $feed->setTitle($feedPost->getTitle());
                $feed->setHeadline($feedPost->getHeadline());
                $feed->setImageLink($feedPost->getImageLink());
                $feed->setBody($feedPost->getBody());
                $feed->setAuthorName($feedPost->getAuthorName());
                $feed->setPostHash($feedPost->getPostHash());
                $feed->setDateCreated($feedPost->getDateCreated());

                $this->em->persist($feed);
                $insertedPosts++;
            }

            if ($i % self::INSERT_BATCH_COUNT == 0) {
                $this->em->flush();
            }
        }

        $this->em->flush();

        return $insertedPosts;
    }

    public function parseFeedsIfNeeded($ttl=60) {
        $fetchKey = 'fetch_needed';

        if (!$this->redis->get($fetchKey)) {
            $this->redis->set($fetchKey, 1);
            $this->redis->expire($fetchKey, $ttl);

            $this->parseAllFeeds();

            return true;
        }

        return false;
    }
}
