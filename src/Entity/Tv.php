<?php

namespace App\Entity;

use App\Entity\Traits\DataTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TvRepository")
 */
class Tv
{

    use DataTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $original_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_air_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin_country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $original_language;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre", inversedBy="tvs")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="comment_tv", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="note_tv")
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favorites_tvs")
     */
    private $favorite_users;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->favorite_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name): self
    {
        $this->original_name = $original_name;

        return $this;
    }

    public function getFirstAirDate(): ?string
    {
        return $this->first_air_date;
    }

    public function setFirstAirDate(string $first_air_date): self
    {
        $this->first_air_date = $first_air_date;

        return $this;
    }

    public function getOriginCountry(): ?string
    {
        return $this->origin_country;
    }

    public function setOriginCountry(?string $origin_country): self
    {
        $this->origin_country = $origin_country;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->original_language;
    }

    public function setOriginalLanguage(string $original_language): self
    {
        $this->original_language = $original_language;

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre($genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
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
            $comment->setCommentTv($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCommentTv() === $this) {
                $comment->setCommentTv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setNoteTv($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getNoteTv() === $this) {
                $note->setNoteTv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favorite_users;
    }

    public function addFavoriteUser(User $favoriteUser): self
    {
        if (!$this->favorite_users->contains($favoriteUser)) {
            $this->favorite_users[] = $favoriteUser;
            $favoriteUser->addFavoriteTv($this);
        }

        return $this;
    }

    public function removeFavoriteUser(User $favoriteUser): self
    {
        if ($this->favorite_users->contains($favoriteUser)) {
            $this->favorite_users->removeElement($favoriteUser);
            $favoriteUser->removeFavoriteTv($this);
        }

        return $this;
    }
}
