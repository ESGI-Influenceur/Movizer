<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="comments")
     */
    private $comment_movie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tv", inversedBy="comments")
     */
    private $comment_tv;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCommentUser(): ?User
    {
        return $this->comment_user;
    }

    public function setCommentUser(?User $comment_user): self
    {
        $this->comment_user = $comment_user;

        return $this;
    }

    public function getCommentMovie(): ?Movie
    {
        return $this->comment_movie;
    }

    public function setCommentMovie(?Movie $comment_movie): self
    {
        $this->comment_movie = $comment_movie;

        return $this;
    }

    public function getCommentTv(): ?Tv
    {
        return $this->comment_tv;
    }

    public function setCommentTv(?Tv $comment_tv): self
    {
        $this->comment_tv = $comment_tv;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString() {
        return $this->content;
    }
}
