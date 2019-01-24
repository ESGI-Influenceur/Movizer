<?php

namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait DataTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster_path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backdrop_path;

    /**
     * @ORM\Column(type="text")
     */
    private $overview;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)
     */
    private $average_note;

    /**
     * @return mixed
     */
    public function getPosterPath()
    {
        return $this->poster_path;
    }

    /**
     * @param mixed $poster_path
     */
    public function setPosterPath($poster_path): void
    {
        $this->poster_path = $poster_path;
    }

    /**
     * @return mixed
     */
    public function getBackdropPath()
    {
        return $this->backdrop_path;
    }

    /**
     * @param mixed $backdrop_path
     */
    public function setBackdropPath($backdrop_path): void
    {
        $this->backdrop_path = $backdrop_path;
    }

    /**
     * @return mixed
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param mixed $overview
     */
    public function setOverview($overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return mixed
     */
    public function getAverageNote()
    {
        return $this->average_note;
    }

    /**
     * @param mixed $average_note
     */
    public function setAverageNote($average_note): void
    {
        if ($this->average_note === "0.00"){
            $this->average_note = $average_note;
        } else {
            $this->average_note = ($this->average_note + $average_note) / 2;
        }
    }

}