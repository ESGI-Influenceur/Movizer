<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="notes")
     */
    private $note_movie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\tv", inversedBy="notes")
     */
    private $note_tv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $note_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNoteMovie(): ?Movie
    {
        return $this->note_movie;
    }

    public function setNoteMovie(?Movie $note_movie): self
    {
        $this->note_movie = $note_movie;

        return $this;
    }

    public function getNoteTv(): ?tv
    {
        return $this->note_tv;
    }

    public function setNoteTv(?tv $note_tv): self
    {
        $this->note_tv = $note_tv;

        return $this;
    }

    public function getNoteUser(): ?User
    {
        return $this->note_user;
    }

    public function setNoteUser(?User $note_user): self
    {
        $this->note_user = $note_user;

        return $this;
    }
}
