<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 05/10/2018
 * Time: 11:02
 */

// src/Entity/Movie.php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie")
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="movie")
     */
    protected $genre;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}