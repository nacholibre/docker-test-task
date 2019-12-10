<?php

namespace App\Service\Parsers;

use App\Entity\FeedPost;
use App\Service\Parsers\ParserUtils;

class FeedBParser implements FeedParserInterface {
    public function parsePost(array $data) : ParsedPostInterface {
        $parserUtils = new ParserUtils;

        $type = FeedPost::FEED_TYPE_B;
        $title = $data['articleTitle'];
        $body = $data['articleBody'];
        $data['published'] = str_replace([' am', ' pm'], '', $data['published']);
        $dateCreated = \DateTime::createFromFormat('d M Y H:i:s a', $data['published']);
        $authorName = $data['author'];
        $headline = $data['headline'];

        $postHash = $parserUtils->generateHash($type, $data['uid']);

        $post = new ParsedPost;
        $post->setType($type);
        $post->setTitle($title);
        $post->setBody($body);
        $post->setHeadline($headline);
        $post->setAuthorName($authorName);
        $post->setDateCreated($dateCreated);
        $post->setPostHash($postHash);

        return $post;
    }
}
