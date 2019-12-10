<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedPostRepository")
 */
class FeedPost
{
    const FEED_TYPE_A = 1;
    const FEED_TYPE_B = 2;
    const FEED_TYPE_C = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(name="type", type="integer")
    */
    private $type;

    /**
    * @ORM\Column(name="title", type="string", length=255)
    */
    private $title;

    /**
    * @ORM\Column(name="headline", type="text", nullable=true)
    */
    private $headline;

    /**
    * @ORM\Column(name="image_link", type="string", length=255, nullable=true)
    */
    private $imageLink;

    /**
    * @ORM\Column(name="body", type="text")
    */
    private $body;

    /**
    * @ORM\Column(name="author_name", type="string", length=255)
    */
    private $authorName;

    /**
    * @ORM\Column(name="post_hash", type="string", length=255, unique=true)
    */
    private $postHash;

    /**
    * @ORM\Column(name="date_created", type="datetime")
    */
    private $dateCreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(?string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getPostHash(): ?string
    {
        return $this->postHash;
    }

    public function setPostHash(string $postHash): self
    {
        $this->postHash = $postHash;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
