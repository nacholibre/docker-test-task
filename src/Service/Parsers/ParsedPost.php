<?php

namespace App\Service\Parsers;

class ParsedPost implements ParsedPostInterface {
    private $type;
    private $title;
    private $headline = null;
    private $imageLink = null;
    private $body;
    private $authorName;
    private $postHash;
    private $dateCreated;

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() : int {
        return $this->type;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function setHeadline($headline) {
        $this->headline = $headline;
    }

    public function getHeadline() : ?string {
        return $this->headline;
    }

    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }

    public function getImageLink() : ?string {
        return $this->imageLink;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getBody() : string {
        return $this->body;
    }

    public function setAuthorName($name) {
        $this->authorName = $name;
    }

    public function getAuthorName() : string {
        return $this->authorName;
    }

    public function setPostHash($postHash) {
        $this->postHash = $postHash;
    }

    public function getPostHash() : string {
        return $this->postHash;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    public function getDateCreated() : \DateTime {
        return $this->dateCreated;
    }
}
