<?php

namespace App\Service\Parsers;

use App\Entity\FeedPost;
use App\Service\Parsers\ParserUtils;

class FeedAParser implements FeedParserInterface {
    public function parsePost(array $data) : ParsedPostInterface {
        $parserUtils = new ParserUtils;

        $type = FeedPost::FEED_TYPE_A;
        $title = $data['title'];
        $body = $data['bodyText'];
        $dateCreated = \DateTime::createFromFormat('d-m-Y H:i:s', $data['dateCreated']);
        $authorName = $data['authorName'];

        $postHash = $parserUtils->generateHash($type, $data['id']);

        $post = new ParsedPost;
        $post->setType($type);
        $post->setTitle($title);
        $post->setBody($body);
        $post->setAuthorName($authorName);
        $post->setDateCreated($dateCreated);
        $post->setPostHash($postHash);

        return $post;
    }
}
