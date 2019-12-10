<?php

namespace App\Service\Parsers;

interface ParsedPostInterface {
    public function getType() : int;
    public function getTitle() : string;
    public function getHeadline() : ?string;
    public function getImageLink() : ?string;
    public function getBody() : string;
    public function getAuthorName() : string;
    public function getPostHash() : string;
    public function getDateCreated() : \DateTime;
}
