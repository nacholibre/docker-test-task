<?php

namespace App\Service\Parsers;

interface FeedParserInterface {
    public function parsePost(array $data) : ParsedPostInterface;
}
