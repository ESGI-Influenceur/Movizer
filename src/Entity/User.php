<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 05/10/2018
 * Time: 11:02
 */

// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="comment_user", orphanRemoval=true)
     */
    public $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="favorite_users")
     */
    public $favorite_movies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tv", inversedBy="favorite_users")
     */
    public $favorite_tvs;

    public function __construct()
    {
        parent::__construct();
        $this->comments = new ArrayCollection();
        $this->favorite_movies = new ArrayCollection();
        $this->favorite_tvs = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommentUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCommentUser() === $this) {
                $comment->setCommentUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getFavoriteMovie(): Collection
    {
        return $this->favorite_movies;
    }

    public function addFavoriteMovie(Movie $favoriteMovie): self
    {
        if (!$this->favorite_movies->contains($favoriteMovie)) {
            $this->favorite_movies[] = $favoriteMovie;
        }

        return $this;
    }

    public function removeFavoriteMovie(Movie $favoriteMovie): self
    {
        if ($this->favorite_movies->contains($favoriteMovie)) {
            $this->favorite_movies->removeElement($favoriteMovie);
        }

        return $this;
    }

    /**
     * @return Collection|Tv[]
     */
    public function getFavoriteTvs(): Collection
    {
        return $this->favorite_tvs;
    }

    public function addFavoriteTv(Tv $favoritesTv): self
    {
        if (!$this->favorite_tvs->contains($favoritesTv)) {
            $this->favorite_tvs[] = $favoritesTv;
        }

        return $this;
    }

    public function removeFavoriteTv(Tv $favoritesTv): self
    {
        if ($this->favorite_tvs->contains($favoritesTv)) {
            $this->favorite_tvs->removeElement($favoritesTv);
        }

        return $this;
    }
}