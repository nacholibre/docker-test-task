<?php

namespace App\Service\Parsers;

use App\Entity\FeedPost;
use App\Service\Parsers\ParserUtils;

class FeedCParser implements FeedParserInterface {
    public function parsePost(array $data) : ParsedPostInterface {
        $parserUtils = new ParserUtils;

        $type = FeedPost::FEED_TYPE_C;
        $title = $data['item_title'];
        $body = $data['item_text'];
        $dateCreated = \DateTime::createFromFormat('d\/m\/Y \- H:i:s', $data['published_on']);
        $authorName = $data['author_first_name'] . ' ' . $data['author_last_name'];
        $headline = $data['preface'];
        $imageLink = $data['image_link'];

        $postHash = $parserUtils->generateHash($type, $data['UUID']);

        $post = new ParsedPost;
        $post->setType($type);
        $post->setTitle($title);
        $post->setBody($body);
        $post->setImageLink($imageLink);
        $post->setHeadline($headline);
        $post->setAuthorName($authorName);
        $post->setDateCreated($dateCreated);
        $post->setPostHash($postHash);

        return $post;
    }
}
